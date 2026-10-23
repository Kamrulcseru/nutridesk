<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyDelivery;
use App\Models\Fruit;
use App\Models\Order;
use App\Models\Package;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();

        // Key Metrics
        $totalSubscribers = Subscription::where('subscription_status', 'active')->count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');
        $totalUsers = User::count();
        $totalFruits = Fruit::count();

        // Today's Deliveries stats
        $todayDeliveries = DailyDelivery::where('delivery_date', $today)->get();
        $todayTotal = $todayDeliveries->count();
        $todayDelivered = $todayDeliveries->where('status', 'delivered')->count();
        $todayOutForDelivery = $todayDeliveries->where('status', 'out_for_delivery')->count();
        $todayPreparing = $todayDeliveries->where('status', 'preparing')->count();
        $todayScheduled = $todayDeliveries->where('status', 'scheduled')->count();
        $todayPaused = $todayDeliveries->where('status', 'paused_by_user')->count();

        // Subscriptions by health condition
        $healthDistribution = [
            'general' => Subscription::where('health_condition', 'general')->count(),
            'diabetes' => Subscription::where('health_condition', 'diabetes')->count(),
            'kidney' => Subscription::where('health_condition', 'kidney')->count(),
            'heart' => Subscription::where('health_condition', 'heart')->count(),
        ];

        // Recent orders
        $recentOrders = Order::with(['user', 'package'])->latest()->take(6)->get();

        // Recent subscriptions
        $recentSubscriptions = Subscription::with(['user', 'package'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalSubscribers',
            'totalRevenue',
            'totalUsers',
            'totalFruits',
            'todayTotal',
            'todayDelivered',
            'todayOutForDelivery',
            'todayPreparing',
            'todayScheduled',
            'todayPaused',
            'healthDistribution',
            'recentOrders',
            'recentSubscriptions'
        ));
    }
}
