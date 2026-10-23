@extends('layouts.app')

@section('content')
<div class="py-10 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Top Profile Welcome Banner -->
        <div class="bg-gradient-to-r from-emerald-800 to-teal-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 bg-emerald-700/60 text-emerald-200 text-xs font-bold px-3 py-1 rounded-full border border-emerald-600/40">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span>{{ app()->getLocale() == 'bn' ? 'সক্রিয় গ্রাহক পোর্টাল' : 'Active Subscriber Portal' }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white">
                    {{ app()->getLocale() == 'bn' ? 'স্বাগতম, ' . $user->name . '!' : 'Welcome, ' . $user->name . '!' }}
                </h1>
                <p class="text-xs sm:text-sm text-emerald-100 max-w-xl">
                    <i class="fa-solid fa-location-dot text-emerald-400 mr-1"></i>
                    {{ $user->office_name ?? 'My Office' }} &bull; {{ $user->office_floor ?? 'Floor' }}, {{ $user->desk_number ?? 'Desk' }} &bull; {{ $user->phone }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('customer.orders') }}" class="bg-white/10 hover:bg-white/20 text-white font-semibold text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-white/20 transition flex items-center gap-2">
                    <i class="fa-solid fa-receipt"></i>
                    <span>{{ app()->getLocale() == 'bn' ? 'অর্ডার ও ইনভয়েস' : 'Orders & Invoices' }}</span>
                </a>
                <a href="{{ route('home') }}#packages" class="bg-emerald-500 hover:bg-emerald-400 text-emerald-950 font-bold text-xs sm:text-sm px-4 py-2.5 rounded-xl shadow-lg transition flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i>
                    <span>{{ app()->getLocale() == 'bn' ? 'নতুন সাবস্ক্রিপশন' : 'New Plan' }}</span>
                </a>
            </div>
        </div>

        @if(!$activeSubscription)
            <!-- No Active Plan Empty State -->
            <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 max-w-xl mx-auto shadow-sm">
                <div class="w-20 h-20 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-3xl mx-auto mb-4">
                    <i class="fa-solid fa-apple-whole"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">
                    {{ app()->getLocale() == 'bn' ? 'আপনার কোনো সক্রিয় সাবস্ক্রিপশন নেই' : 'No Active Subscription Found' }}
                </h3>
                <p class="text-slate-500 text-sm mb-6">
                    {{ app()->getLocale() == 'bn' ? 'অফিস ডেস্কে প্রতিদিন ১০০ গ্রাম ফ্রেশ ফল পেতে আপনার পছন্দমতো একটি প্যাকেজ সাবস্ক্রাইব করুন।' : 'Subscribe to a daily fruit package to start receiving delicious nutrition right at your desk.' }}
                </p>
                <a href="{{ route('home') }}#packages" class="bg-emerald-600 text-white font-bold px-6 py-3 rounded-xl text-sm hover:bg-emerald-700 shadow-md transition inline-block">
                    {{ app()->getLocale() == 'bn' ? 'প্যাকেজসমূহ দেখুন' : 'Explore Packages' }}
                </a>
            </div>
        @else
            <!-- Active Subscription Details -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left: Subscription KPI Card -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
                        <div class="flex justify-between items-start border-b border-slate-100 pb-4">
                            <div>
                                <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-600">
                                    {{ app()->getLocale() == 'bn' ? 'সক্রিয় প্যাকেজ' : 'Active Plan' }}
                                </span>
                                <h3 class="text-xl font-extrabold text-slate-900 mt-0.5">
                                    {{ app()->getLocale() == 'bn' ? $activeSubscription->package->name_bn : $activeSubscription->package->name_en }}
                                </h3>
                                <p class="text-xs text-slate-500 mt-0.5">ID: {{ $activeSubscription->subscription_code }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide bg-emerald-100 text-emerald-800 border border-emerald-200">
                                {{ $activeSubscription->subscription_status }}
                            </span>
                        </div>

                        <!-- Progress Bar of Delivered Days -->
                        <div class="space-y-2">
                            <div class="flex justify-between text-xs font-semibold text-slate-700">
                                <span>{{ app()->getLocale() == 'bn' ? 'ডেলিভারি সম্পন্ন:' : 'Deliveries Completed:' }}</span>
                                <span class="font-bold text-emerald-600">{{ $activeSubscription->delivered_days_count }} / {{ $activeSubscription->total_delivery_days }} {{ app()->getLocale() == 'bn' ? 'দিন' : 'Days' }}</span>
                            </div>
                            @php
                                $percent = $activeSubscription->total_delivery_days > 0 
                                    ? min(100, round(($activeSubscription->delivered_days_count / $activeSubscription->total_delivery_days) * 100)) 
                                    : 0;
                            @endphp
                            <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden border border-slate-200">
                                <div class="bg-emerald-500 h-3 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                            </div>
                            <div class="flex justify-between text-[11px] text-slate-400">
                                <span>{{ $percent }}% সম্পন্ন</span>
                                <span>{{ $activeSubscription->paused_days_count }} দিন পজ করা</span>
                            </div>
                        </div>

                        <!-- Plan Specifications Grid -->
                        <div class="grid grid-cols-2 gap-3 text-xs">
                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <span class="text-slate-400 block">{{ app()->getLocale() == 'bn' ? 'স্বাস্থ্য প্রোফাইল' : 'Health Profile' }}</span>
                                <span class="font-bold text-slate-800 uppercase mt-0.5 block flex items-center gap-1">
                                    @if($activeSubscription->health_condition === 'diabetes')
                                        <i class="fa-solid fa-droplet text-amber-500"></i> Diabetes Care
                                    @elseif($activeSubscription->health_condition === 'kidney')
                                        <i class="fa-solid fa-virus text-sky-500"></i> Kidney Care
                                    @else
                                        <i class="fa-solid fa-apple-whole text-emerald-500"></i> General Fitness
                                    @endif
                                </span>
                            </div>

                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <span class="text-slate-400 block">{{ app()->getLocale() == 'bn' ? 'দৈনিক পরিমাণ' : 'Daily Portion' }}</span>
                                <span class="font-bold text-slate-800 mt-0.5 block">
                                    {{ $activeSubscription->daily_grams }}g ({{ $activeSubscription->total_persons }} জন)
                                </span>
                            </div>

                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <span class="text-slate-400 block">{{ app()->getLocale() == 'bn' ? 'ডেলিভারি স্লট' : 'Time Slot' }}</span>
                                <span class="font-bold text-slate-800 mt-0.5 block text-[11px]">
                                    {{ $activeSubscription->delivery_time_slot }}
                                </span>
                            </div>

                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <span class="text-slate-400 block">{{ app()->getLocale() == 'bn' ? 'পেমেন্ট স্ট্যাটাস' : 'Payment Status' }}</span>
                                <span class="font-bold text-emerald-700 uppercase mt-0.5 block">
                                    {{ $activeSubscription->payment_status }}
                                </span>
                            </div>
                        </div>

                        <!-- Desk Information Box -->
                        <div class="bg-emerald-50/70 p-4 rounded-2xl border border-emerald-100 text-xs text-emerald-950 space-y-1">
                            <span class="font-bold block text-emerald-800">{{ app()->getLocale() == 'bn' ? 'ডেলিভারি ডেস্কে তথ্য:' : 'Desk Information:' }}</span>
                            <p>{{ $activeSubscription->delivery_office_name }} &bull; {{ $activeSubscription->delivery_office_address }}</p>
                            <p class="font-medium text-emerald-700">{{ $activeSubscription->delivery_floor }}, {{ $activeSubscription->delivery_desk }}</p>
                            <p class="text-[11px] text-slate-500 mt-1">কল: {{ $activeSubscription->delivery_phone }}</p>
                        </div>
                    </div>
                </div>

                <!-- Right: Delivery Calendar & 1-Click Pause Feature -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 border-b border-slate-100 pb-4">
                            <div>
                                <h3 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                                    <i class="fa-solid fa-calendar-days text-emerald-600"></i>
                                    <span>{{ app()->getLocale() == 'bn' ? 'দৈনিক ডেলিভারি ক্যালেন্ডার' : 'Daily Delivery Schedule' }}</span>
                                </h3>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    {{ app()->getLocale() == 'bn' ? 'ছুটি থাকলে "Pause" বাটনে চাপ দিন, মেয়াদের শেষে অতিরিক্ত দিন যুক্ত হবে।' : 'Going on leave? Click "Pause" to carry forward that day.' }}
                                </p>
                            </div>
                        </div>

                        <!-- Deliveries List -->
                        <div class="space-y-3">
                            @foreach($activeSubscription->dailyDeliveries as $delivery)
                                <div class="p-4 rounded-2xl border transition flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 {{ $delivery->status === 'delivered' ? 'bg-emerald-50/40 border-emerald-200' : ($delivery->status === 'paused_by_user' ? 'bg-amber-50/50 border-amber-200' : 'bg-slate-50 border-slate-200') }}">
                                    <!-- Date & Details -->
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-xl {{ $delivery->status === 'delivered' ? 'bg-emerald-100 text-emerald-700' : ($delivery->status === 'paused_by_user' ? 'bg-amber-100 text-amber-700' : 'bg-slate-200 text-slate-700') }} flex flex-col items-center justify-center font-bold text-xs flex-shrink-0">
                                            <span>{{ \Carbon\Carbon::parse($delivery->delivery_date)->format('d') }}</span>
                                            <span class="text-[9px] uppercase font-semibold">{{ \Carbon\Carbon::parse($delivery->delivery_date)->format('M') }}</span>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <h4 class="font-bold text-sm text-slate-900">{{ $delivery->day_name }}</h4>
                                                @if($delivery->status === 'delivered')
                                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                                        <i class="fa-solid fa-check mr-0.5"></i> Delivered
                                                    </span>
                                                @elseif($delivery->status === 'preparing')
                                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800 animate-pulse">
                                                        <i class="fa-solid fa-bowl-food mr-0.5"></i> Preparing
                                                    </span>
                                                @elseif($delivery->status === 'out_for_delivery')
                                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-100 text-indigo-800">
                                                        <i class="fa-solid fa-motorcycle mr-0.5"></i> On the Way
                                                    </span>
                                                @elseif($delivery->status === 'paused_by_user')
                                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-900 border border-amber-300">
                                                        <i class="fa-solid fa-pause mr-0.5"></i> Paused
                                                    </span>
                                                @else
                                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-200 text-slate-700">
                                                        Scheduled
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-slate-500 mt-0.5">{{ $delivery->fruits_summary }}</p>
                                            @if($delivery->pause_reason)
                                                <p class="text-[11px] text-amber-700 mt-0.5"><i class="fa-solid fa-info-circle mr-1"></i>{{ $delivery->pause_reason }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Action Button (Pause / Resume) -->
                                    <div class="flex-shrink-0 w-full sm:w-auto text-right">
                                        @if($delivery->status === 'scheduled')
                                            <form action="{{ route('customer.subscriptions.pause', $activeSubscription->id) }}" method="POST" onsubmit="return confirm('এই দিনের ডেলিভারি কি পজ করতে চান? এই দিনটি আপনার সাবস্ক্রিপশন মেয়াদের শেষে যোগ হবে।')">
                                                @csrf
                                                <input type="hidden" name="delivery_date" value="{{ $delivery->delivery_date }}">
                                                <button type="submit" class="w-full sm:w-auto px-3.5 py-1.5 rounded-xl border border-slate-300 hover:border-amber-400 bg-white hover:bg-amber-50 text-slate-700 hover:text-amber-800 text-xs font-semibold transition flex items-center justify-center gap-1.5 shadow-sm">
                                                    <i class="fa-solid fa-circle-pause text-amber-500"></i>
                                                    <span>{{ app()->getLocale() == 'bn' ? 'পজ / ছুটি' : 'Pause Day' }}</span>
                                                </button>
                                            </form>
                                        @elseif($delivery->status === 'paused_by_user')
                                            <form action="{{ route('customer.subscriptions.resume', $activeSubscription->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="delivery_date" value="{{ $delivery->delivery_date }}">
                                                <button type="submit" class="w-full sm:w-auto px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold transition flex items-center justify-center gap-1.5 shadow-sm">
                                                    <i class="fa-solid fa-play text-white"></i>
                                                    <span>{{ app()->getLocale() == 'bn' ? 'চালু করুন' : 'Resume Day' }}</span>
                                                </button>
                                            </form>
                                        @elseif($delivery->status === 'delivered')
                                            <span class="text-xs text-emerald-600 font-semibold flex items-center gap-1">
                                                <i class="fa-solid fa-circle-check"></i>
                                                {{ $delivery->delivered_at ? \Carbon\Carbon::parse($delivery->delivered_at)->format('h:i A') : 'Received' }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
