@extends('layouts.admin')

@section('title', 'Order #' . $order->order_number)
@section('page_title', 'Order Details & Fulfillment')

@section('content')
<div class="max-w-4xl space-y-6">
    <a href="{{ route('admin.orders.index') }}" class="text-xs text-emerald-700 hover:underline flex items-center gap-1.5 font-bold mb-2">
        <i class="fa-solid fa-arrow-left"></i>
        <span>Back to Orders List</span>
    </a>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
        <!-- Left: Order details -->
        <div class="md:col-span-7 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-6">
            <div class="flex justify-between items-start border-b border-slate-100 pb-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-600">Order Information</span>
                    <h2 class="text-2xl font-black text-slate-900 mt-1">#{{ $order->order_number }}</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-blue-100 text-blue-800">
                    {{ $order->status }}
                </span>
            </div>

            <!-- Customer & Office Desk -->
            <div class="space-y-3 text-xs">
                <h4 class="font-bold text-slate-900 uppercase tracking-wider text-[11px] text-slate-400">Customer & Delivery Office</h4>
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-2">
                    <p class="font-bold text-slate-900 text-sm">{{ $order->customer_name }}</p>
                    <p class="text-slate-600"><i class="fa-solid fa-phone text-emerald-600 mr-1.5"></i>{{ $order->customer_phone }}</p>
                    <p class="text-slate-600"><i class="fa-solid fa-envelope text-emerald-600 mr-1.5"></i>{{ $order->customer_email }}</p>
                    <div class="pt-2 border-t border-slate-200 text-slate-700">
                        <p class="font-semibold text-slate-800"><i class="fa-solid fa-building text-indigo-600 mr-1.5"></i>Delivery Desk:</p>
                        <p class="mt-0.5">{{ $order->delivery_address }}</p>
                    </div>
                </div>
            </div>

            <!-- Package & Pricing -->
            <div class="space-y-3 text-xs">
                <h4 class="font-bold text-slate-900 uppercase tracking-wider text-[11px] text-slate-400">Package & Amount</h4>
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-2">
                    <div class="flex justify-between">
                        <span class="font-semibold text-slate-800">{{ $order->package ? $order->package->name_bn : 'Custom Package' }}</span>
                        <span class="font-bold text-slate-900">৳{{ number_format($order->subtotal, 0) }}</span>
                    </div>
                    <div class="flex justify-between text-slate-500">
                        <span>Discount:</span>
                        <span>৳0</span>
                    </div>
                    <div class="flex justify-between text-sm font-extrabold text-emerald-700 pt-2 border-t border-slate-200">
                        <span>Total Amount:</span>
                        <span>৳{{ number_format($order->total_amount, 0) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Process Order Status Form -->
        <div class="md:col-span-5 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-5">
            <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                <i class="fa-solid fa-sliders text-emerald-600"></i>
                <span>Update Order Status</span>
            </h3>

            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Order Fulfillment Status</label>
                    <select name="status" class="w-full text-xs rounded-xl border-slate-200 focus:border-emerald-500 p-2.5 border font-semibold">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing (In Preparation)</option>
                        <option value="active" {{ $order->status === 'active' ? 'selected' : '' }}>Active (Subscription Running)</option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Payment Status</label>
                    <select name="payment_status" class="w-full text-xs rounded-xl border-slate-200 focus:border-emerald-500 p-2.5 border font-semibold">
                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Payment Trx ID</label>
                    <input type="text" name="payment_trx_id" value="{{ $order->payment_trx_id }}" class="w-full text-xs rounded-xl border-slate-200 focus:border-emerald-500 p-2.5 border">
                </div>

                <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-md transition">
                    Save Changes
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
