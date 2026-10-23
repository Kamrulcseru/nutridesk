@extends('layouts.app')

@section('content')
<div class="py-12 bg-slate-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <!-- Top Toolbar -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <a href="{{ route('customer.orders') }}" class="text-xs text-emerald-700 hover:underline flex items-center gap-1.5 font-bold">
                <i class="fa-solid fa-arrow-left"></i>
                <span>{{ app()->getLocale() == 'bn' ? 'অর্ডার তালিকায় ফিরুন' : 'Back to Orders' }}</span>
            </a>

            <div class="flex items-center gap-3">
                <button onclick="window.print()" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 rounded-xl text-xs font-bold transition flex items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-print"></i>
                    <span>Print Invoice</span>
                </button>

                <a href="{{ route('customer.orders.invoice.download', $order->id) }}" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-2 shadow-md shadow-emerald-600/20">
                    <i class="fa-solid fa-file-pdf"></i>
                    <span>Download PDF</span>
                </a>
            </div>
        </div>

        <!-- The Printable Invoice Card -->
        <div class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200/80 shadow-xl space-y-8 print:shadow-none print:border-none print:p-0" id="invoice">
            <!-- Header: Brand & Invoice Meta -->
            <div class="flex flex-col sm:flex-row justify-between items-start gap-6 border-b border-slate-100 pb-8">
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-500 to-amber-400 flex items-center justify-center text-white">
                            <i class="fa-solid fa-apple-whole text-xl"></i>
                        </div>
                        <span class="text-2xl font-black text-slate-900">Nutri<span class="text-emerald-600">Desk</span></span>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        NutriDesk Fresh Fruit Technologies Ltd.<br>
                        Plot 12, Road 4, Gulshan-2, Dhaka-1212<br>
                        BIN / Tax ID: 004829103-0101 &bull; Hotline: +880 1700-000001
                    </p>
                </div>

                <div class="sm:text-right space-y-1">
                    <span class="text-xs uppercase font-extrabold tracking-widest text-emerald-600 block">TAX INVOICE / বিল</span>
                    <h2 class="text-2xl font-black text-slate-900">#{{ $order->order_number }}</h2>
                    <p class="text-xs text-slate-400">Date: {{ $order->created_at->format('d F Y') }}</p>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase bg-emerald-100 text-emerald-800 border border-emerald-300 mt-2">
                        PAID / পরিশোধিত
                    </span>
                </div>
            </div>

            <!-- Customer and Delivery Destination -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 text-xs">
                <div class="space-y-1">
                    <span class="font-bold text-slate-400 uppercase tracking-wider block mb-1">Billed To (Customer):</span>
                    <p class="font-extrabold text-slate-900 text-sm">{{ $order->customer_name }}</p>
                    <p class="text-slate-600">{{ $order->customer_phone }}</p>
                    <p class="text-slate-600">{{ $order->customer_email }}</p>
                </div>

                <div class="space-y-1 sm:text-right">
                    <span class="font-bold text-slate-400 uppercase tracking-wider block mb-1">Office Delivery Destination:</span>
                    <p class="font-extrabold text-slate-900 text-sm">{{ $order->subscription->delivery_office_name ?? $order->delivery_address }}</p>
                    <p class="text-slate-600">{{ $order->subscription->delivery_floor ?? '' }}, {{ $order->subscription->delivery_desk ?? '' }}</p>
                    <p class="text-emerald-700 font-medium">Slot: {{ $order->subscription->delivery_time_slot ?? '10:00 AM - 11:30 AM' }}</p>
                </div>
            </div>

            <!-- Itemized Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-900 uppercase tracking-wider font-bold border-y border-slate-200">
                        <tr>
                            <th class="py-3 px-4">Item Description</th>
                            <th class="py-3 px-4 text-center">Dietary Profile</th>
                            <th class="py-3 px-4 text-center">Persons</th>
                            <th class="py-3 px-4 text-center">Duration</th>
                            <th class="py-3 px-4 text-right">Total Price</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr>
                            <td class="py-4 px-4">
                                <span class="font-bold text-slate-900 text-sm block">
                                    {{ $order->package ? (app()->getLocale() == 'bn' ? $order->package->name_bn : $order->package->name_en) : 'NutriDesk Fruit Subscription' }}
                                </span>
                                <span class="text-slate-500 text-[11px]">
                                    Daily {{ $order->subscription->daily_grams ?? 130 }}g portioned fresh cut fruits in food-grade hygienic bowl
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="capitalize font-bold text-slate-700 bg-slate-100 px-2.5 py-1 rounded-md">
                                    {{ $order->subscription->health_condition ?? 'general' }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center font-bold text-slate-800">
                                {{ $order->subscription->total_persons ?? 1 }}
                            </td>
                            <td class="py-4 px-4 text-center font-semibold text-slate-600">
                                {{ $order->subscription && $order->subscription->plan_duration === '7_days' ? '7 Days (Trial)' : '1 Month (22 Workdays)' }}
                            </td>
                            <td class="py-4 px-4 text-right font-extrabold text-slate-900 text-sm">
                                ৳{{ number_format($order->subtotal, 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Calculations Summary -->
            <div class="flex justify-end pt-4 border-t border-slate-100">
                <div class="w-full sm:w-72 space-y-2 text-xs">
                    <div class="flex justify-between text-slate-600">
                        <span>Subtotal:</span>
                        <span class="font-bold text-slate-900">৳{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Desk Delivery & Handling:</span>
                        <span class="font-bold text-emerald-600 uppercase text-[11px]">FREE</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>VAT / Tax (Included 5%):</span>
                        <span class="font-medium text-slate-500">৳{{ number_format(($order->total_amount * 0.05), 2) }}</span>
                    </div>
                    <div class="flex justify-between text-base font-black text-slate-900 pt-3 border-t border-slate-200">
                        <span>Total Paid:</span>
                        <span class="text-emerald-600 text-xl font-black">৳{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment & Security Note -->
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-slate-500">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-credit-card text-emerald-600 text-lg"></i>
                    <span>Paid via <strong>{{ strtoupper($order->payment_method) }}</strong> &bull; Trx ID: <strong class="font-mono text-slate-700">{{ $order->payment_trx_id ?? 'AUTO_VERIFIED' }}</strong></span>
                </div>
                <div class="text-emerald-700 font-bold">
                    NutriDesk Verified Invoice
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
