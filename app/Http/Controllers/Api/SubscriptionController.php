<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DailyDelivery;
use App\Models\Order;
use App\Models\Package;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $subscriptions = $request->user()
            ->subscriptions()
            ->with(['package', 'dailyDeliveries' => function ($q) {
                $q->orderBy('delivery_date', 'asc');
            }])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $subscriptions,
        ]);
    }

    public function show(Request $request, $id)
    {
        $subscription = $request->user()
            ->subscriptions()
            ->with(['package', 'dailyDeliveries', 'orders'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $subscription,
        ]);
    }

    public function store(Request $request)
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

        $package = Package::findOrFail($validated['package_id']);

        // Pricing calculation
        $basePrice = $validated['plan_duration'] === '7_days' 
            ? $package->price_7_days 
            : $package->price_30_days;

        // If corporate or custom persons scale
        $multiplier = $validated['total_persons'] > $package->max_persons
            ? ($validated['total_persons'] / max($package->max_persons, 1))
            : 1;

        $totalAmount = round($basePrice * $multiplier, 2);
        $totalDays = $validated['plan_duration'] === '7_days' ? 5 : 22; // Office working days
        $gramsPerPerson = $package->grams_per_person_daily;

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = $startDate->copy()->addDays($validated['plan_duration'] === '7_days' ? 7 : 30);

        $subscriptionCode = 'ND-SUB-' . date('Y') . '-' . strtoupper(Str::random(6));

        $subscription = Subscription::create([
            'subscription_code' => $subscriptionCode,
            'user_id' => $request->user()->id,
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

        // Generate delivery calendar slots for working days (Sunday to Thursday)
        $currentDay = $startDate->copy();
        $generatedDeliveries = 0;

        while ($generatedDeliveries < $totalDays) {
            // Check if Sunday(0) to Thursday(4)
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

        // Create initial order record
        $order = Order::create([
            'order_number' => 'ND-ORD-' . date('Y') . '-' . rand(10000, 99999),
            'user_id' => $request->user()->id,
            'subscription_id' => $subscription->id,
            'package_id' => $package->id,
            'order_type' => 'subscription',
            'subtotal' => $totalAmount,
            'discount' => 0.00,
            'total_amount' => $totalAmount,
            'payment_method' => $validated['payment_method'],
            'payment_trx_id' => strtoupper($validated['payment_method']) . '_' . Str::random(10),
            'payment_status' => $subscription->payment_status,
            'status' => 'active',
            'customer_name' => $request->user()->name,
            'customer_email' => $request->user()->email,
            'customer_phone' => $validated['delivery_phone'],
            'delivery_address' => $validated['delivery_office_name'] . ', ' . $validated['delivery_office_address'],
            'customer_notes' => $validated['special_notes'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Subscription created successfully!',
            'message_bn' => 'আপনার সাবস্ক্রিপশন সফলভাবে সক্রিয় করা হয়েছে!',
            'subscription' => $subscription->load(['package', 'dailyDeliveries']),
            'order' => $order,
        ], 201);
    }

    public function pauseDay(Request $request, $id)
    {
        $validated = $request->validate([
            'delivery_date' => 'required|date|after_or_equal:today',
            'reason' => 'nullable|string|max:255',
        ]);

        $subscription = $request->user()->subscriptions()->findOrFail($id);

        $delivery = DailyDelivery::where('subscription_id', $subscription->id)
            ->where('delivery_date', $validated['delivery_date'])
            ->first();

        if (!$delivery) {
            return response()->json([
                'success' => false,
                'message' => 'Delivery not found for this date',
                'message_bn' => 'এই তারিখের কোনো ডেলিভারি পাওয়া যায়নি',
            ], 404);
        }

        if (in_array($delivery->status, ['delivered', 'out_for_delivery'])) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot pause a delivery that is already out or delivered.',
                'message_bn' => 'যে ডেলিভারি ইতিমধ্যে পাঠানো হয়েছে তা পজ করা সম্ভব নয়।',
            ], 422);
        }

        $delivery->update([
            'status' => 'paused_by_user',
            'pause_reason' => $validated['reason'] ?? 'গ্রাহক কর্তৃক সাময়িক ছুটি / Customer leave',
        ]);

        // Add 1 extended day to the subscription so the customer doesn't lose their portion!
        $subscription->increment('paused_days_count');

        // Schedule compensation day after the last scheduled delivery
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

        return response()->json([
            'success' => true,
            'message' => 'Delivery for ' . $validated['delivery_date'] . ' paused successfully. A replacement day has been added to the end of your plan!',
            'message_bn' => $validated['delivery_date'] . ' তারিখের ডেলিভারি সফলভাবে পজ করা হয়েছে। আপনার মেয়াদের শেষে একটি অতিরিক্ত দিন যোগ করে দেওয়া হয়েছে!',
            'delivery' => $delivery,
        ]);
    }

    public function resumeDay(Request $request, $id)
    {
        $validated = $request->validate([
            'delivery_date' => 'required|date|after_or_equal:today',
        ]);

        $subscription = $request->user()->subscriptions()->findOrFail($id);

        $delivery = DailyDelivery::where('subscription_id', $subscription->id)
            ->where('delivery_date', $validated['delivery_date'])
            ->where('status', 'paused_by_user')
            ->first();

        if (!$delivery) {
            return response()->json([
                'success' => false,
                'message' => 'No paused delivery found for this date',
                'message_bn' => 'এই তারিখে কোনো পজ করা ডেলিভারি পাওয়া যায়নি',
            ], 404);
        }

        $delivery->update([
            'status' => 'scheduled',
            'pause_reason' => null,
        ]);

        if ($subscription->paused_days_count > 0) {
            $subscription->decrement('paused_days_count');
        }

        return response()->json([
            'success' => true,
            'message' => 'Delivery resumed successfully for ' . $validated['delivery_date'],
            'message_bn' => $validated['delivery_date'] . ' তারিখের ডেলিভারি পুনরায় চালু করা হয়েছে।',
            'delivery' => $delivery,
        ]);
    }
}
