<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyDelivery;
use App\Models\Order;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderProcessingController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'package', 'subscription']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        $orders = $query->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'package', 'subscription.dailyDeliveries']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,active,completed,cancelled',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'payment_trx_id' => 'nullable|string',
        ]);

        $order->update($validated);

        if ($order->subscription) {
            $order->subscription->update([
                'payment_status' => $validated['payment_status'],
                'subscription_status' => $validated['status'] === 'cancelled' ? 'cancelled' : 'active',
            ]);
        }

        return redirect()->back()->with('success', 'Order status updated successfully by ' . auth()->user()->name);
    }
}
