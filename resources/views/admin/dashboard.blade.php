@extends('layouts.admin')

@section('title', 'Executive Dashboard')
@section('page_title', app()->getLocale() == 'bn' ? 'অ্যাডমিন ড্যাশবোর্ড ও লাইভ অপারেশন' : 'Admin Operations Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Top KPI Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Active Subscribers -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">
                    {{ app()->getLocale() == 'bn' ? 'মোট সক্রিয় গ্রাহক' : 'Active Subscribers' }}
                </span>
                <h3 class="text-3xl font-black text-slate-900">{{ $totalSubscribers }}</h3>
                <span class="text-[11px] text-emerald-600 font-semibold mt-1 inline-flex items-center gap-1">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    {{ app()->getLocale() == 'bn' ? 'নিয়মিত ডেস্ক ডেলিভারি' : 'Regular Desk Subscriptions' }}
                </span>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl border border-emerald-100">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>

        <!-- Today's Total Deliveries -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">
                    {{ app()->getLocale() == 'bn' ? 'আজকের ডেলিভারি বক্স' : 'Today\'s Fruit Bowls' }}
                </span>
                <h3 class="text-3xl font-black text-blue-600">{{ $todayTotal }}</h3>
                <span class="text-[11px] text-slate-500 font-medium mt-1 inline-flex items-center gap-1">
                    {{ $todayDelivered }} Delivered &bull; {{ $todayPaused }} Paused
                </span>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl border border-blue-100">
                <i class="fa-solid fa-box"></i>
            </div>
        </div>

        <!-- Today's Kitchen Prep Progress -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">
                    {{ app()->getLocale() == 'bn' ? 'কিচেন ও ডিসপ্যাচ' : 'Kitchen Dispatch' }}
                </span>
                <h3 class="text-3xl font-black text-amber-600">{{ $todayDelivered + $todayOutForDelivery }}/{{ max($todayTotal, 1) }}</h3>
                <span class="text-[11px] text-amber-700 font-semibold mt-1 inline-flex items-center gap-1">
                    <i class="fa-solid fa-motorcycle"></i>
                    {{ $todayOutForDelivery }} on the way
                </span>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl border border-amber-100">
                <i class="fa-solid fa-utensils"></i>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">
                    {{ app()->getLocale() == 'bn' ? 'মোট রেভিনিউ' : 'Total Revenue' }}
                </span>
                <h3 class="text-3xl font-black text-slate-900">৳{{ number_format($totalRevenue, 0) }}</h3>
                <span class="text-[11px] text-emerald-600 font-semibold mt-1 inline-flex items-center gap-1">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ app()->getLocale() == 'bn' ? 'পরিশোধিত সাবস্ক্রিপশন' : 'Paid Subscriptions' }}
                </span>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl border border-purple-100">
                <i class="fa-solid fa-bangladeshi-taka-sign"></i>
            </div>
        </div>
    </div>

    <!-- Health Breakdown & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Health Conditions Distribution -->
        <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-slate-900 text-lg">
                        {{ app()->getLocale() == 'bn' ? 'স্বাস্থ্য প্রোফাইল অনুসারে গ্রাহক বিভাজন' : 'Subscribers by Health Profile' }}
                    </h3>
                    <p class="text-xs text-slate-500">{{ app()->getLocale() == 'bn' ? 'পুষ্টিবিদদের প্রস্তুতকৃত স্পেশালাইজড ডায়েট বন্টন' : 'Distribution of medical & dietary categories' }}</p>
                </div>
                <a href="{{ route('admin.kitchen.index') }}" class="text-xs font-bold text-emerald-700 hover:underline">
                    {{ app()->getLocale() == 'bn' ? 'কিচেন ভিউ দেখুন' : 'View Kitchen Board' }} &rarr;
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-center">
                    <i class="fa-solid fa-apple-whole text-emerald-600 text-xl mb-1"></i>
                    <span class="block text-2xl font-black text-slate-900">{{ $healthDistribution['general'] }}</span>
                    <span class="text-xs font-bold text-emerald-800">General</span>
                </div>
                <div class="p-4 rounded-2xl bg-amber-50 border border-amber-100 text-center">
                    <i class="fa-solid fa-droplet text-amber-500 text-xl mb-1"></i>
                    <span class="block text-2xl font-black text-slate-900">{{ $healthDistribution['diabetes'] }}</span>
                    <span class="text-xs font-bold text-amber-800">Diabetes Care</span>
                </div>
                <div class="p-4 rounded-2xl bg-sky-50 border border-sky-100 text-center">
                    <i class="fa-solid fa-virus text-sky-500 text-xl mb-1"></i>
                    <span class="block text-2xl font-black text-slate-900">{{ $healthDistribution['kidney'] }}</span>
                    <span class="text-xs font-bold text-sky-800">Kidney Care</span>
                </div>
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-100 text-center">
                    <i class="fa-solid fa-heart text-rose-500 text-xl mb-1"></i>
                    <span class="block text-2xl font-black text-slate-900">{{ $healthDistribution['heart'] }}</span>
                    <span class="text-xs font-bold text-rose-800">Heart Care</span>
                </div>
            </div>

            <!-- Fast Quick Operations -->
            <div class="border-t border-slate-100 pt-6">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-3">দ্রুত একশন / Quick Actions</span>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.kitchen.index') }}" class="bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-2">
                        <i class="fa-solid fa-utensils"></i>
                        <span>আজকের কিচেন বোর্ড খুলুন</span>
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-2">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span>অর্ডার প্রসেসিং তালিকা</span>
                    </a>
                    @if(auth()->user()->role === 'super_admin')
                        <a href="{{ route('admin.users.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-2">
                            <i class="fa-solid fa-user-plus"></i>
                            <span>নতুন ইউজার তৈরি করুন</span>
                        </a>
                        <a href="{{ route('admin.packages.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-2">
                            <i class="fa-solid fa-box"></i>
                            <span>নতুন প্যাকেজ তৈরি করুন</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right: Recent Subscriptions -->
        <div class="lg:col-span-5 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-4">
            <h3 class="font-bold text-slate-900 text-lg flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-emerald-600"></i>
                <span>{{ app()->getLocale() == 'bn' ? 'সাম্প্রতিক সাবস্ক্রিপশনসমূহ' : 'Recent Subscriptions' }}</span>
            </h3>

            <div class="space-y-3">
                @foreach($recentSubscriptions as $sub)
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 flex justify-between items-center text-xs">
                        <div>
                            <span class="font-bold text-slate-900 block">{{ $sub->user->name ?? 'Customer' }}</span>
                            <span class="text-slate-500 text-[11px]">{{ $sub->delivery_office_name }} &bull; {{ $sub->package->name_bn ?? 'Pack' }}</span>
                        </div>
                        <div class="text-right">
                            <span class="font-extrabold text-emerald-600 block">৳{{ number_format($sub->total_amount, 0) }}</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $sub->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $sub->payment_status }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-sm">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="font-bold text-slate-900 text-lg">
                    {{ app()->getLocale() == 'bn' ? 'সাম্প্রতিক অর্ডার তালিকা' : 'Recent Orders' }}
                </h3>
                <p class="text-xs text-slate-500">{{ app()->getLocale() == 'bn' ? 'গ্রাহকদের নতুন অর্ডার ও পেমেন্ট রেকর্ড' : 'Latest orders with status and office desk info' }}</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-emerald-700 hover:underline">
                {{ app()->getLocale() == 'bn' ? 'সব অর্ডার দেখুন' : 'View All Orders' }} &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-900 uppercase tracking-wider font-bold border-b border-slate-100">
                    <tr>
                        <th class="p-4">Order #</th>
                        <th class="p-4">Customer</th>
                        <th class="p-4">Office & Desk</th>
                        <th class="p-4">Package</th>
                        <th class="p-4">Amount</th>
                        <th class="p-4">Payment</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($recentOrders as $ord)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4 font-bold text-slate-900">{{ $ord->order_number }}</td>
                            <td class="p-4 font-semibold text-slate-800">
                                {{ $ord->customer_name }}
                                <span class="block text-[10px] text-slate-400 font-normal">{{ $ord->customer_phone }}</span>
                            </td>
                            <td class="p-4 text-slate-600">{{ $ord->delivery_address }}</td>
                            <td class="p-4 font-medium text-slate-800">{{ $ord->package ? $ord->package->name_bn : 'Custom' }}</td>
                            <td class="p-4 font-extrabold text-emerald-600">৳{{ number_format($ord->total_amount, 0) }}</td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded font-bold uppercase text-[10px] {{ $ord->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $ord->payment_status }} ({{ $ord->payment_method }})
                                </span>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded font-bold uppercase text-[10px] bg-blue-100 text-blue-800">
                                    {{ $ord->status }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('admin.orders.show', $ord->id) }}" class="text-emerald-700 hover:text-emerald-900 font-bold">
                                    Process &rarr;
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
