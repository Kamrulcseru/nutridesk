@extends('layouts.admin')

@section('title', 'Orders Management')
@section('page_title', app()->getLocale() == 'bn' ? 'অর্ডার প্রসেসিং ও ম্যানেজমেন্ট' : 'Orders Processing & Fulfillment')

@section('content')
<div class="space-y-6">
    <!-- Filter & Search Bar -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Order #, Name, Phone..." class="text-xs rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 p-2.5 border w-48 sm:w-60">

            <select name="status" class="text-xs rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 p-2.5 border" onchange="this.form.submit()">
                <option value="">{{ app()->getLocale() == 'bn' ? 'সকল স্ট্যাটাস' : 'All Statuses' }}</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>

            <select name="payment_status" class="text-xs rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 p-2.5 border" onchange="this.form.submit()">
                <option value="">{{ app()->getLocale() == 'bn' ? 'সকল পেমেন্ট' : 'All Payments' }}</option>
                <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Pending Payment</option>
            </select>

            <button type="submit" class="bg-slate-900 text-white text-xs font-bold px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">
                <i class="fa-solid fa-filter mr-1"></i> Filter
            </button>
        </form>

        <span class="text-xs text-slate-500 font-semibold">
            {{ $orders->total() }} {{ app()->getLocale() == 'bn' ? 'টি অর্ডার পাওয়া গেছে' : 'Orders Found' }}
        </span>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-900 uppercase tracking-wider font-bold border-b border-slate-100">
                    <tr>
                        <th class="p-4">Order #</th>
                        <th class="p-4">Customer</th>
                        <th class="p-4">Desk Location</th>
                        <th class="p-4">Package</th>
                        <th class="p-4">Amount</th>
                        <th class="p-4">Payment</th>
                        <th class="p-4">Order Status</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4 font-bold text-slate-900">{{ $order->order_number }}</td>
                            <td class="p-4">
                                <span class="font-bold text-slate-800 block">{{ $order->customer_name }}</span>
                                <span class="text-[11px] text-slate-400">{{ $order->customer_phone }}</span>
                            </td>
                            <td class="p-4 text-slate-600 max-w-xs truncate">{{ $order->delivery_address }}</td>
                            <td class="p-4 font-semibold text-slate-800">
                                {{ $order->package ? (app()->getLocale() == 'bn' ? $order->package->name_bn : $order->package->name_en) : 'Custom' }}
                            </td>
                            <td class="p-4 font-extrabold text-emerald-600">৳{{ number_format($order->total_amount, 0) }}</td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded font-bold uppercase text-[10px] {{ $order->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $order->payment_status }}
                                </span>
                                <span class="block text-[10px] text-slate-400 mt-0.5 uppercase">{{ $order->payment_method }}</span>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded font-bold uppercase text-[10px] {{ $order->status === 'active' || $order->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center gap-1 bg-slate-100 hover:bg-emerald-600 hover:text-white text-slate-700 px-3 py-1.5 rounded-lg font-bold text-xs transition">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>Process</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-slate-400">
                                {{ app()->getLocale() == 'bn' ? 'কোনো অর্ডার পাওয়া যায়নি' : 'No orders matching filter criteria' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $orders->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
