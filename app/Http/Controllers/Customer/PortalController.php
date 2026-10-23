<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\DailyDelivery;
use App\Models\Order;
use App\Models\Package;
use App\Models\Subscription;
use App\Services\PaymentService;
use App\Services\SmsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PortalController extends Controller
{
    protected PaymentService $paymentService;
    protected SmsService $smsService;

    public function __construct(PaymentService $paymentService, SmsService $smsService)
    {
        $this->paymentService = $paymentService;
        $this->smsService = $smsService;
    }
    public function showCheckout(Package $package)
    {
        $user = auth()->user();
        return view('customer.checkout', compact('package', 'user'));
    }

    public function processCheckout(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'plan_duration' => 'required|in:7_days,30_days',
            'health_condition' => 'required|in:general,diabetes,kidney,heart',
            'total_persons' => 'required|integer|min:1|max:50',
            'delivery_office_name' => 'required|string|max:255',
            'delivery_office_address' => 'required|string',
            'delivery_floor' => 'nullable|string',
            'delivery_desk' => 'nullable|string',
            'delivery_phone' => 'required|string',
            'delivery_time_slot' => 'nullable|string',
            'start_date' => 'required|date|after_or_equal:today',
            'payment_method' => 'required|in:bkash,nagad,card,cash_on_delivery,corporate_invoice',
            'special_notes' => 'nullable|string',
        ]);

        $user = auth()->user();
        $package = Package::findOrFail($validated['package_id']);

        $basePrice = $validated['plan_duration'] === '7_days'
            ? $package->price_7_days
            : $package->price_30_days;

        $multiplier = $validated['total_persons'] > $package->max_persons
            ? ($validated['total_persons'] / max($package->max_persons, 1))
            : 1;

        $totalAmount = round($basePrice * $multiplier, 2);
        $totalDays = $validated['plan_duration'] === '7_days' ? 5 : 22;
        $gramsPerPerson = $package->grams_per_person_daily;

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = $startDate->copy()->addDays($validated['plan_duration'] === '7_days' ? 7 : 30);

        $subscriptionCode = 'ND-SUB-' . date('Y') . '-' . strtoupper(Str::random(6));

        $subscription = Subscription::create([
            'subscription_code' => $subscriptionCode,
            'user_id' => $user->id,
            'package_id' => $package->id,
            'plan_duration' => $validated['plan_duration'],
            'health_condition' => $validated['health_condition'],
            'total_persons' => $validated['total_persons'],
            'daily_grams' => $gramsPerPerson * $validated['total_persons'],
            'delivery_office_name' => $validated['delivery_office_name'],
            'delivery_office_address' => $validated['delivery_office_address'],
            'delivery_floor' => $validated['delivery_floor'] ?? null,
            'delivery_desk' => $validated['delivery_desk'] ?? null,
            'delivery_phone' => $validated['delivery_phone'],
            'delivery_time_slot' => $validated['delivery_time_slot'] ?? '10:00 AM - 11:30 AM',
            'delivery_days_type' => 'office_days_sun_thu',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_delivery_days' => $totalDays,
            'delivered_days_count' => 0,
            'paused_days_count' => 0,
            'total_amount' => $totalAmount,
            'payment_status' => in_array($validated['payment_method'], ['cash_on_delivery', 'corporate_invoice']) ? 'pending' : 'paid',
            'subscription_status' => 'active',
            'special_notes' => $validated['special_notes'] ?? null,
        ]);

        // Generate delivery slots for office working days (Sun-Thu)
        $currentDay = $startDate->copy();
        $generatedDeliveries = 0;

        while ($generatedDeliveries < $totalDays) {
            if (in_array($currentDay->dayOfWeek, [Carbon::SUNDAY, Carbon::MONDAY, Carbon::TUESDAY, Carbon::WEDNESDAY, Carbon::THURSDAY])) {
                DailyDelivery::create([
                    'subscription_id' => $subscription->id,
                    'delivery_date' => $currentDay->toDateString(),
                    'day_name' => $currentDay->format('l'),
                    'status' => 'scheduled',
                    'fruits_summary' => $package->name_bn . ' (' . ($gramsPerPerson * $validated['total_persons']) . 'g)',
                ]);
                $generatedDeliveries++;
            }
            $currentDay->addDay();
        }

        // Create Order
        $isOnlinePayment = in_array($validated['payment_method'], ['bkash', 'nagad', 'card']);

        $order = Order::create([
            'order_number' => 'ND-ORD-' . date('Y') . '-' . rand(10000, 99999),
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
            'package_id' => $package->id,
            'order_type' => 'subscription',
            'subtotal' => $totalAmount,
            'discount' => 0.00,
            'total_amount' => $totalAmount,
            'payment_method' => $validated['payment_method'],
            'payment_trx_id' => null,
            'payment_status' => 'pending',
            'status' => 'pending',
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => $validated['delivery_phone'],
            'delivery_address' => $validated['delivery_office_name'] . ', ' . $validated['delivery_office_address'],
            'customer_notes' => $validated['special_notes'] ?? null,
        ]);

        if ($isOnlinePayment) {
            $payment = $this->paymentService->initiatePayment($order);
            return redirect($payment['redirect_url']);
        }

        // For corporate invoice / cash on delivery
        $this->paymentService->completePayment($order, 'INV_' . Str::random(8));

        return redirect()->route('customer.dashboard')->with('success', 'অভিনন্দন! আপনার সাবস্ক্রিপশন সফলভাবে সম্পন্ন হয়েছে এবং ফোনে নিশ্চিতকরণ এসএমএস পাঠানো হয়েছে।');
    }

    public function dashboard()
    {
        $user = auth()->user();
        $subscriptions = $user->subscriptions()
            ->with(['package', 'dailyDeliveries' => function ($q) {
                $q->orderBy('delivery_date', 'asc');
            }])
            ->latest()
            ->get();

        $activeSubscription = $subscriptions->firstWhere('subscription_status', 'active') ?? $subscriptions->first();

        return view('customer.dashboard', compact('user', 'subscriptions', 'activeSubscription'));
    }

    public function pauseDelivery(Request $request, Subscription $subscription)
    {
        if ($subscription->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'delivery_date' => 'required|date|after_or_equal:today',
            'pause_reason' => 'nullable|string|max:255',
        ]);

        $delivery = DailyDelivery::where('subscription_id', $subscription->id)
            ->where('delivery_date', $validated['delivery_date'])
            ->firstOrFail();

        if (in_array($delivery->status, ['delivered', 'out_for_delivery'])) {
            return back()->with('error', 'যে ডেলিভারি ইতিমধ্যে পাঠানো হয়েছে তা পজ করা সম্ভব নয়।');
        }

        $delivery->update([
            'status' => 'paused_by_user',
            'pause_reason' => $validated['pause_reason'] ?? 'গ্রাহক কর্তৃক ছুটি / Leave',
        ]);

        $subscription->increment('paused_days_count');

        // Add 1 extra replacement day to the end of the plan
        $lastDelivery = DailyDelivery::where('subscription_id', $subscription->id)
            ->orderBy('delivery_date', 'desc')
            ->first();

        $nextDate = Carbon::parse($lastDelivery->delivery_date)->addDay();
        while (!in_array($nextDate->dayOfWeek, [Carbon::SUNDAY, Carbon::MONDAY, Carbon::TUESDAY, Carbon::WEDNESDAY, Carbon::THURSDAY])) {
            $nextDate->addDay();
        }

        DailyDelivery::create([
            'subscription_id' => $subscription->id,
            'delivery_date' => $nextDate->toDateString(),
            'day_name' => $nextDate->format('l'),
            'status' => 'scheduled',
            'fruits_summary' => $delivery->fruits_summary . ' (পজ ক্ষতিপূরণ দিন / Compensated)',
            'notes' => 'Rescheduled due to pause on ' . $validated['delivery_date'],
        ]);

        $this->smsService->sendPaused($delivery);

        return back()->with('success', $validated['delivery_date'] . ' তারিখের ডেলিভারি সফলভাবে পজ করা হয়েছে এবং ফোনে কনফার্মেশন এসএমএস পাঠানো হয়েছে!');
    }

    public function resumeDelivery(Request $request, Subscription $subscription)
    {
        if ($subscription->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'delivery_date' => 'required|date|after_or_equal:today',
        ]);

        $delivery = DailyDelivery::where('subscription_id', $subscription->id)
            ->where('delivery_date', $validated['delivery_date'])
            ->where('status', 'paused_by_user')
            ->firstOrFail();

        $delivery->update([
            'status' => 'scheduled',
            'pause_reason' => null,
        ]);

        if ($subscription->paused_days_count > 0) {
            $subscription->decrement('paused_days_count');
        }

        return back()->with('success', $validated['delivery_date'] . ' তারিখের ডেলিভারি পুনরায় চালু করা হয়েছে।');
    }

    public function orders()
    {
        $orders = auth()->user()->orders()->with(['package', 'subscription'])->latest()->get();
        return view('customer.orders', compact('orders'));
    }
}
