<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyDelivery;
use App\Services\SmsService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KitchenController extends Controller
{
    protected SmsService $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }
    public function index(Request $request)
    {
        $selectedDate = $request->query('date', Carbon::today()->toDateString());

        $deliveries = DailyDelivery::with(['subscription.user', 'subscription.package'])
            ->where('delivery_date', $selectedDate)
            ->get();

        // Calculate preparation breakdown
        $totalBoxes = $deliveries->whereNotIn('status', ['paused_by_user', 'cancelled'])->count();
        $totalGeneral = $deliveries->filter(fn($d) => $d->subscription && $d->subscription->health_condition === 'general' && !in_array($d->status, ['paused_by_user', 'cancelled']))->count();
        $totalDiabetic = $deliveries->filter(fn($d) => $d->subscription && $d->subscription->health_condition === 'diabetes' && !in_array($d->status, ['paused_by_user', 'cancelled']))->count();
        $totalKidney = $deliveries->filter(fn($d) => $d->subscription && $d->subscription->health_condition === 'kidney' && !in_array($d->status, ['paused_by_user', 'cancelled']))->count();
        $totalHeart = $deliveries->filter(fn($d) => $d->subscription && $d->subscription->health_condition === 'heart' && !in_array($d->status, ['paused_by_user', 'cancelled']))->count();

        // Total approximate grams needed in kitchen today
        $totalGramsNeeded = $deliveries->whereNotIn('status', ['paused_by_user', 'cancelled'])
            ->sum(fn($d) => $d->subscription ? $d->subscription->daily_grams : 120);

        return view('admin.kitchen.index', compact(
            'deliveries',
            'selectedDate',
            'totalBoxes',
            'totalGeneral',
            'totalDiabetic',
            'totalKidney',
            'totalHeart',
            'totalGramsNeeded'
        ));
    }

    public function updateDeliveryStatus(Request $request, DailyDelivery $delivery)
    {
        $validated = $request->validate([
            'status' => 'required|in:scheduled,preparing,out_for_delivery,delivered,cancelled',
            'delivery_person' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if ($validated['status'] === 'delivered' && !$delivery->delivered_at) {
            $validated['delivered_at'] = Carbon::now();
            if ($delivery->subscription) {
                $delivery->subscription->increment('delivered_days_count');
            }
        }

        $delivery->update($validated);

        if ($validated['status'] === 'out_for_delivery') {
            $this->smsService->sendOutForDelivery($delivery);
        } elseif ($validated['status'] === 'delivered') {
            $this->smsService->sendDelivered($delivery);
        }

        return redirect()->back()->with('success', 'Delivery status for #' . $delivery->id . ' updated to ' . strtoupper(str_replace('_', ' ', $validated['status'])) . ' and SMS notification sent!');
    }
}
