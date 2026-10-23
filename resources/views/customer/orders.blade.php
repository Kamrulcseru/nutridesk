@extends('layouts.app')

@section('content')
<div class="py-10 bg-slate-50 min-h-[70vh]">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <a href="{{ route('customer.dashboard') }}" class="text-xs text-emerald-700 hover:underline flex items-center gap-1.5 mb-2 font-medium">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>{{ app()->getLocale() == 'bn' ? 'ড্যাশবোর্ডে ফিরে যান' : 'Back to Dashboard' }}</span>
                </a>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                    {{ app()->getLocale() == 'bn' ? 'আমার অর্ডার ও সাবস্ক্রিপশন হিস্ট্রি' : 'Order History & Invoices' }}
                </h1>
            </div>
        </div>

        @if($orders->isEmpty())
            <div class="bg-white rounded-3xl p-10 text-center border border-slate-200">
                <i class="fa-solid fa-receipt text-4xl text-slate-300 mb-3"></i>
                <p class="text-slate-500 text-sm">{{ app()->getLocale() == 'bn' ? 'কোনো অর্ডার পাওয়া যায়নি।' : 'No orders found.' }}</p>
            </div>
        @else
            <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-900 text-xs uppercase tracking-wider font-bold border-b border-slate-200">
                            <tr>
                                <th class="p-4 sm:p-5">Order #</th>
                                <th class="p-4 sm:p-5">Package</th>
                                <th class="p-4 sm:p-5">Date</th>
                                <th class="p-4 sm:p-5">Payment</th>
                                <th class="p-4 sm:p-5">Amount</th>
                                <th class="p-4 sm:p-5">Status</th>
                                <th class="p-4 sm:p-5 text-right">Invoice</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($orders as $order)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="p-4 sm:p-5 font-bold text-slate-900">{{ $order->order_number }}</td>
                                    <td class="p-4 sm:p-5">
                                        <span class="font-semibold text-slate-800">{{ $order->package ? (app()->getLocale() == 'bn' ? $order->package->name_bn : $order->package->name_en) : 'Custom Pack' }}</span>
                                    </td>
                                    <td class="p-4 sm:p-5 text-xs text-slate-500">{{ $order->created_at->format('d M Y, h:i A') }}</td>
                                    <td class="p-4 sm:p-5">
                                        <span class="text-xs font-bold uppercase text-slate-700 bg-slate-100 px-2 py-0.5 rounded border border-slate-200">
                                            {{ $order->payment_method }}
                                        </span>
                                    </td>
                                    <td class="p-4 sm:p-5 font-extrabold text-emerald-600">৳{{ number_format($order->total_amount, 0) }}</td>
                                    <td class="p-4 sm:p-5">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase {{ $order->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                            {{ $order->payment_status }}
                                        </span>
                                    </td>
                                    <td class="p-4 sm:p-5 text-right space-x-1">
                                        <a href="{{ route('customer.orders.invoice', $order->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                                            <i class="fa-solid fa-receipt"></i>
                                            <span>View</span>
                                        </a>
                                        <a href="{{ route('customer.orders.invoice.download', $order->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-bold transition" title="Download PDF">
                                            <i class="fa-solid fa-file-pdf"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
