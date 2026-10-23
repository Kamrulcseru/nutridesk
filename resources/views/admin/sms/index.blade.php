@extends('layouts.admin')

@section('title', 'SMS Delivery Logs')
@section('page_title', app()->getLocale() == 'bn' ? 'এসএমএস নোটিফিকেশন লগ ও হিস্ট্রি' : 'SMS Notification Logs')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4">
        <div>
            <h3 class="font-bold text-slate-900 text-base">
                {{ app()->getLocale() == 'bn' ? 'অফিস কর্মীদের প্রেরিত এসএমএস রেকর্ড' : 'Dispatched SMS History' }}
            </h3>
            <p class="text-xs text-slate-500">Live logs of order confirmations, rider out-for-delivery, and desk delivered SMS</p>
        </div>

        <form method="GET" action="{{ route('admin.sms.index') }}" class="flex items-center gap-3">
            <select name="type" class="text-xs rounded-xl border-slate-200 p-2.5 border" onchange="this.form.submit()">
                <option value="">All Types</option>
                <option value="order_confirmation" {{ request('type') === 'order_confirmation' ? 'selected' : '' }}>Order Confirmation</option>
                <option value="out_for_delivery" {{ request('type') === 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                <option value="delivered" {{ request('type') === 'delivered' ? 'selected' : '' }}>Delivered at Desk</option>
                <option value="paused" {{ request('type') === 'paused' ? 'selected' : '' }}>Paused Holiday</option>
            </select>
        </form>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-900 uppercase tracking-wider font-bold border-b border-slate-100">
                    <tr>
                        <th class="p-4">Time</th>
                        <th class="p-4">Recipient Phone</th>
                        <th class="p-4">Notification Type</th>
                        <th class="p-4">Message Content</th>
                        <th class="p-4">Gateway</th>
                        <th class="p-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4 text-slate-400 whitespace-nowrap">{{ $log->created_at->format('d M, h:i A') }}</td>
                            <td class="p-4 font-bold text-slate-800">{{ $log->phone }}</td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-slate-100 text-slate-700">
                                    {{ str_replace('_', ' ', $log->type) }}
                                </span>
                            </td>
                            <td class="p-4 text-slate-700 max-w-md">{{ $log->message }}</td>
                            <td class="p-4 font-mono text-[11px] text-slate-400">{{ $log->gateway }}</td>
                            <td class="p-4">
                                @if($log->status === 'sent')
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                        <i class="fa-solid fa-check mr-1"></i> Sent
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-800">
                                        Failed
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">
                                No SMS logs found yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $logs->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
