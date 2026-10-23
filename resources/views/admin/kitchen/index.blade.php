@extends('layouts.admin')

@section('title', 'Kitchen Preparation & Dispatch Board')
@section('page_title', app()->getLocale() == 'bn' ? 'কিচেন প্রিপারেশন ও ডেলিভারি ডিসপ্যাচ' : 'Kitchen Preparation & Dispatch Board')

@section('content')
<div class="space-y-6">
    <!-- Top Summary & Date Selector -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4">
        <div>
            <h3 class="font-extrabold text-slate-900 text-lg">
                {{ app()->getLocale() == 'bn' ? 'দৈনিক ফল কাটিং ও প্যাকিং তালিকা' : 'Daily Fruit Slicing & Packing Checklist' }}
            </h3>
            <p class="text-xs text-slate-500">
                {{ date('l, d F Y', strtotime($selectedDate)) }} &bull; {{ app()->getLocale() == 'bn' ? 'অফিস ডেস্কে সকাল ১১টার আগেই পৌঁছানোর জন্য' : 'Dispatch deadline: 10:45 AM' }}
            </p>
        </div>

        <form method="GET" action="{{ route('admin.kitchen.index') }}" class="flex items-center gap-2">
            <label class="text-xs font-bold text-slate-600">Date:</label>
            <input type="date" name="date" value="{{ $selectedDate }}" class="text-xs rounded-xl border-slate-200 focus:border-emerald-500 p-2 border font-medium" onchange="this.form.submit()">
        </form>
    </div>

    <!-- Kitchen Requirements Metric Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm text-center">
            <span class="text-xs font-bold text-slate-400 block mb-1">মোট বক্স / Bowls</span>
            <span class="text-3xl font-black text-slate-900">{{ $totalBoxes }}</span>
            <span class="text-[11px] text-emerald-600 font-semibold block mt-1">~{{ round($totalGramsNeeded / 1000, 2) }} kg ফল</span>
        </div>

        <div class="bg-emerald-50/70 p-5 rounded-2xl border border-emerald-200 shadow-sm text-center">
            <span class="text-xs font-bold text-emerald-800 block mb-1">সাধারণ / General</span>
            <span class="text-3xl font-black text-emerald-950">{{ $totalGeneral }}</span>
            <span class="text-[11px] text-emerald-700 block mt-1">রেগুলার মিক্স বাউল</span>
        </div>

        <div class="bg-amber-50/70 p-5 rounded-2xl border border-amber-200 shadow-sm text-center">
            <span class="text-xs font-bold text-amber-800 block mb-1">ডায়াবেটিস / Diabetic</span>
            <span class="text-3xl font-black text-amber-950">{{ $totalDiabetic }}</span>
            <span class="text-[11px] text-amber-700 block mt-1">লো-জিআই (Low-GI)</span>
        </div>

        <div class="bg-sky-50/70 p-5 rounded-2xl border border-sky-200 shadow-sm text-center">
            <span class="text-xs font-bold text-sky-800 block mb-1">কিডনি কেয়ার / Kidney</span>
            <span class="text-3xl font-black text-sky-950">{{ $totalKidney }}</span>
            <span class="text-[11px] text-sky-700 block mt-1">লো পটাশিয়াম ফল</span>
        </div>

        <div class="bg-rose-50/70 p-5 rounded-2xl border border-rose-200 shadow-sm text-center">
            <span class="text-xs font-bold text-rose-800 block mb-1">হার্ট কেয়ার / Heart</span>
            <span class="text-3xl font-black text-rose-950">{{ $totalHeart }}</span>
            <span class="text-[11px] text-rose-700 block mt-1">অ্যান্টিঅক্সিডেন্ট মিক্স</span>
        </div>
    </div>

    <!-- Deliveries Checklist Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-sm">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-slate-900 text-base">
                {{ app()->getLocale() == 'bn' ? 'আজকের ডেলিভারি অর্ডার তালিকা ও রাইডার এসাইন' : 'Today\'s Dispatch Checklist & Rider Assignment' }}
            </h3>
            <span class="text-xs text-slate-400 font-medium">Total: {{ $deliveries->count() }} records</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-900 uppercase tracking-wider font-bold border-b border-slate-100">
                    <tr>
                        <th class="p-4">Delivery #</th>
                        <th class="p-4">Customer & Phone</th>
                        <th class="p-4">Office & Desk</th>
                        <th class="p-4">Health Condition</th>
                        <th class="p-4">Portion Pack</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Update Status & Rider</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($deliveries as $deliv)
                        <tr class="hover:bg-slate-50/50 transition {{ $deliv->status === 'delivered' ? 'bg-emerald-50/30' : ($deliv->status === 'paused_by_user' ? 'bg-amber-50/30' : '') }}">
                            <td class="p-4 font-bold text-slate-900">#{{ $deliv->id }}</td>
                            <td class="p-4 font-semibold text-slate-800">
                                {{ $deliv->subscription->user->name ?? 'Customer' }}
                                <span class="block text-[10px] text-slate-400">{{ $deliv->subscription->delivery_phone }}</span>
                            </td>
                            <td class="p-4">
                                <span class="font-bold text-slate-800 block">{{ $deliv->subscription->delivery_office_name }}</span>
                                <span class="text-slate-500 block text-[11px]">{{ $deliv->subscription->delivery_floor }}, {{ $deliv->subscription->delivery_desk }}</span>
                            </td>
                            <td class="p-4">
                                @php $cond = $deliv->subscription->health_condition ?? 'general'; @endphp
                                @if($cond === 'diabetes')
                                    <span class="px-2 py-0.5 rounded font-bold uppercase text-[10px] bg-amber-100 text-amber-800 border border-amber-300">
                                        <i class="fa-solid fa-droplet mr-0.5"></i> Diabetes
                                    </span>
                                @elseif($cond === 'kidney')
                                    <span class="px-2 py-0.5 rounded font-bold uppercase text-[10px] bg-sky-100 text-sky-800 border border-sky-300">
                                        <i class="fa-solid fa-virus mr-0.5"></i> Kidney
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded font-bold uppercase text-[10px] bg-emerald-100 text-emerald-800">
                                        General
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 font-medium text-slate-800">
                                {{ $deliv->fruits_summary }}
                            </td>
                            <td class="p-4">
                                @if($deliv->status === 'delivered')
                                    <span class="px-2 py-0.5 rounded font-bold uppercase text-[10px] bg-emerald-100 text-emerald-800 border border-emerald-300">
                                        <i class="fa-solid fa-check mr-0.5"></i> Delivered
                                    </span>
                                @elseif($deliv->status === 'out_for_delivery')
                                    <span class="px-2 py-0.5 rounded font-bold uppercase text-[10px] bg-indigo-100 text-indigo-800 animate-pulse">
                                        <i class="fa-solid fa-motorcycle mr-0.5"></i> On Way
                                    </span>
                                @elseif($deliv->status === 'preparing')
                                    <span class="px-2 py-0.5 rounded font-bold uppercase text-[10px] bg-blue-100 text-blue-800">
                                        Preparing
                                    </span>
                                @elseif($deliv->status === 'paused_by_user')
                                    <span class="px-2 py-0.5 rounded font-bold uppercase text-[10px] bg-amber-100 text-amber-900 border border-amber-300">
                                        Paused
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded font-bold uppercase text-[10px] bg-slate-200 text-slate-700">
                                        Scheduled
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                <form action="{{ route('admin.kitchen.status', $deliv->id) }}" method="POST" class="inline-flex items-center gap-2">
                                    @csrf
                                    <input type="text" name="delivery_person" value="{{ $deliv->delivery_person }}" placeholder="Rider name" class="text-[11px] rounded-lg border-slate-200 p-1.5 border w-24">

                                    <select name="status" class="text-[11px] rounded-lg border-slate-200 p-1.5 border font-semibold">
                                        <option value="scheduled" {{ $deliv->status === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                        <option value="preparing" {{ $deliv->status === 'preparing' ? 'selected' : '' }}>Preparing</option>
                                        <option value="out_for_delivery" {{ $deliv->status === 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                                        <option value="delivered" {{ $deliv->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    </select>

                                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-2.5 py-1.5 rounded-lg text-xs shadow-sm transition">
                                        Save
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400">
                                {{ app()->getLocale() == 'bn' ? 'এই তারিখে কোনো ডেলিভারি শিডিউল নেই।' : 'No deliveries scheduled for this date.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
