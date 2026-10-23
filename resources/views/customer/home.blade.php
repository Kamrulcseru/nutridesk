@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="gradient-hero relative overflow-hidden pt-12 pb-20 border-b border-emerald-100/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Left Text Content -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-100 text-emerald-800 text-xs sm:text-sm font-semibold border border-emerald-200 shadow-sm">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>{{ app()->getLocale() == 'bn' ? 'অফিস কর্মীদের জন্য বিশেষ পুষ্টি সেবা' : 'Tailored for Office Professionals' }}</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight">
                    @if(app()->getLocale() == 'bn')
                        প্রতিদিন <span class="text-emerald-600 underline decoration-amber-400 decoration-wavy">১০০ গ্রাম ফ্রেশ ফল</span>, সরাসরি আপনার অফিস ডেস্কে!
                    @else
                        Daily <span class="text-emerald-600 underline decoration-amber-400 decoration-wavy">100gm Fresh Fruit</span>, Directly To Your Office Desk!
                    @endif
                </h1>

                <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    @if(app()->getLocale() == 'bn')
                        সুস্থ থাকতে প্রতিদিন ১০০ গ্রাম ফল খাওয়া আবশ্যক। কিন্তু অফিসে ফল নিয়ে আসা, ধোয়া ও কাটার ঝামেলার কারণে ফল খাওয়া হয় না। আবার এক কেজি ফলের দাম ৩০০-৪০০ টাকা। <strong>NutriDesk</strong> মাত্র অল্প খরচে প্রতিদিন পুষ্টিবিদ অনুমোদিত বিভিন্ন ফলের ফ্রেশ প্যাক আপনার ডেস্কে পৌঁছে দেয়।
                    @else
                        Eating 100g fruit daily keeps you healthy and avoids doctor visits. But peeling and slicing fruits at the office is messy, and buying a single kg costs ৳300-400. <strong>NutriDesk</strong> delivers dietitian-curated, freshly portioned fruit bowls directly to your desk every workday.
                    @endif
                </p>

                <!-- Value Props Highlights -->
                <div class="grid grid-cols-3 gap-3 pt-2 max-w-xl mx-auto lg:mx-0">
                    <div class="bg-white/80 backdrop-blur p-3 rounded-2xl border border-emerald-100 shadow-sm text-center">
                        <i class="fa-solid fa-bowl-food text-emerald-600 text-xl mb-1"></i>
                        <span class="block font-bold text-xs sm:text-sm text-slate-800">{{ app()->getLocale() == 'bn' ? '১০০/১৫০ গ্রাম ফ্রেশ কাটা ফল' : '100-150g Fresh Cut' }}</span>
                        <span class="text-[11px] text-slate-500">{{ app()->getLocale() == 'bn' ? 'ফুড-গ্রেড পাত্রে' : 'Food-grade Pack' }}</span>
                    </div>
                    <div class="bg-white/80 backdrop-blur p-3 rounded-2xl border border-emerald-100 shadow-sm text-center">
                        <i class="fa-solid fa-user-doctor text-indigo-600 text-xl mb-1"></i>
                        <span class="block font-bold text-xs sm:text-sm text-slate-800">{{ app()->getLocale() == 'bn' ? 'পুষ্টিবিদ অনুমোদিত' : 'Dietitian Curated' }}</span>
                        <span class="text-[11px] text-slate-500">{{ app()->getLocale() == 'bn' ? 'প্রতিদিন ভিন্ন মেনু' : 'Daily Variety' }}</span>
                    </div>
                    <div class="bg-white/80 backdrop-blur p-3 rounded-2xl border border-emerald-100 shadow-sm text-center">
                        <i class="fa-solid fa-calendar-xmark text-amber-600 text-xl mb-1"></i>
                        <span class="block font-bold text-xs sm:text-sm text-slate-800">{{ app()->getLocale() == 'bn' ? 'পজ ও স্কিপ সুবিধা' : 'Pause Anytime' }}</span>
                        <span class="text-[11px] text-slate-500">{{ app()->getLocale() == 'bn' ? 'ছুটিতে টাকা নষ্ট নেই' : 'Carry-Forward Days' }}</span>
                    </div>
                </div>

                <!-- CTAs -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-4">
                    <a href="#packages" class="w-full sm:w-auto bg-emerald-600 text-white font-bold px-8 py-4 rounded-2xl shadow-lg shadow-emerald-600/30 hover:bg-emerald-700 transition flex items-center justify-center gap-3 text-base">
                        <i class="fa-solid fa-bolt text-amber-300"></i>
                        <span>{{ app()->getLocale() == 'bn' ? 'প্যাকেজ পছন্দ করুন' : 'Explore Packages' }}</span>
                    </a>
                    <a href="#menu" class="w-full sm:w-auto bg-white text-slate-700 font-bold px-6 py-4 rounded-2xl border border-slate-200 hover:bg-slate-50 transition flex items-center justify-center gap-2 text-base">
                        <i class="fa-solid fa-calendar-days text-emerald-600"></i>
                        <span>{{ app()->getLocale() == 'bn' ? 'সাপ্তাহিক মেনু দেখুন' : 'Weekly Menu' }}</span>
                    </a>
                </div>
            </div>

            <!-- Right Hero Card / Visual Preview -->
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto max-w-md bg-white rounded-3xl shadow-2xl border border-emerald-100 p-6 overflow-hidden">
                    <div class="absolute top-0 right-0 bg-gradient-to-l from-emerald-500 to-emerald-600 text-white font-bold text-xs py-1.5 px-4 rounded-bl-2xl uppercase tracking-wider">
                        {{ app()->getLocale() == 'bn' ? 'আজকের ফ্রেশ বাউল' : 'Today\'s Bowl' }}
                    </div>

                    <img src="https://images.unsplash.com/photo-1519996529931-28324d5a630e?w=800&auto=format&fit=crop" alt="NutriDesk Fresh Fruit Bowl" class="w-full h-56 object-cover rounded-2xl mb-5 shadow-sm">

                    <div class="space-y-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-lg text-slate-900">{{ app()->getLocale() == 'bn' ? 'শক্তি মিক্স ফ্রুট বাউল (১০০ গ্রাম)' : 'Shakti Mix Fruit Bowl (100gm)' }}</h3>
                                <p class="text-xs text-slate-500">{{ app()->getLocale() == 'bn' ? 'ফুজি আপেল + থাই পেয়ারা + মিষ্টি মাল্টা' : 'Fuji Apple + Thai Guava + Sweet Malta' }}</p>
                            </div>
                            <span class="text-emerald-600 font-black text-xl">৳৫০<span class="text-xs text-slate-400 font-normal">/দিন</span></span>
                        </div>

                        <!-- Nutrition Bar -->
                        <div class="bg-emerald-50 p-3 rounded-xl border border-emerald-100 grid grid-cols-4 text-center text-xs">
                            <div>
                                <span class="block font-bold text-emerald-950">৭৪</span>
                                <span class="text-[10px] text-slate-500">ক্যালরি / kcal</span>
                            </div>
                            <div>
                                <span class="block font-bold text-emerald-950">৩.৮g</span>
                                <span class="text-[10px] text-slate-500">ফাইবার / Fiber</span>
                            </div>
                            <div>
                                <span class="block font-bold text-emerald-950">১৪.৫g</span>
                                <span class="text-[10px] text-slate-500">কার্বস / Carbs</span>
                            </div>
                            <div>
                                <span class="block font-bold text-emerald-600">১২০%</span>
                                <span class="text-[10px] text-slate-500">ভিটামিন সি</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 text-xs text-slate-600 bg-slate-50 p-2.5 rounded-lg">
                            <i class="fa-solid fa-shield-heart text-rose-500"></i>
                            <span>{{ app()->getLocale() == 'bn' ? 'ডায়াবেটিস ও কিডনি রোগীদের জন্য আলাদাভাবে নির্ধারিত ফল দেওয়া হয়।' : 'Custom fruit bowls available for Diabetes & Kidney patients.' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Problem vs Solution Comparison Section -->
<section class="py-16 bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h2 class="text-3xl font-extrabold text-slate-900 mb-4">
                {{ app()->getLocale() == 'bn' ? 'অফিস কর্মীদের কেন NutriDesk দরকার?' : 'Why Office Workers Choose NutriDesk?' }}
            </h2>
            <p class="text-slate-600">
                {{ app()->getLocale() == 'bn' ? 'ফল খাওয়া উচিত কিন্তু অলসতা ও খরচের কারণে আমরা খেতে পারি না। দেখে নিন পার্থকটি:' : 'We all know fruits are essential, but office friction stops us. Here is how we fix it:' }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <!-- The Traditional Friction -->
            <div class="bg-rose-50/70 border border-rose-200/80 rounded-3xl p-6 sm:p-8 space-y-4">
                <div class="flex items-center gap-3 text-rose-700 font-bold text-lg">
                    <div class="w-10 h-10 rounded-full bg-rose-200 flex items-center justify-center text-rose-700">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </div>
                    <span>{{ app()->getLocale() == 'bn' ? 'সাধারণ উপায়ে ফল খাওয়ার সমস্যা' : 'The Traditional Struggle' }}</span>
                </div>
                <ul class="space-y-3 text-sm text-slate-700">
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-circle-xmark text-rose-500 mt-1"></i>
                        <span>{{ app()->getLocale() == 'bn' ? 'এক কেজি ফলের দাম ৩০০-৪০০ টাকা, প্রতিদিন এত টাকা দিয়ে একক ফল কেনা ব্যয়বহুল।' : 'Buying 1kg apples or dragon fruits costs ৳300-400, expensive for single daily intake.' }}</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-circle-xmark text-rose-500 mt-1"></i>
                        <span>{{ app()->getLocale() == 'bn' ? 'অফিসে ফল ধোয়া, কাটা ও পরিবেশন করা খুবই নোংরা ও ঝামেলার কাজ।' : 'Washing, peeling, and cutting sticky fruits on office desks is messy and inconvenient.' }}</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-circle-xmark text-rose-500 mt-1"></i>
                        <span>{{ app()->getLocale() == 'bn' ? 'ফল না খাওয়ার কারণে দুপুরের পর ক্লান্তি আসে এবং পুষ্টির ঘাটতিতে রোগ বাধে।' : 'Skipping daily fruit nutrition leads to mid-day workplace fatigue and vitamin deficiency.' }}</span>
                    </li>
                </ul>
            </div>

            <!-- The NutriDesk Solution -->
            <div class="bg-emerald-50/80 border border-emerald-200 rounded-3xl p-6 sm:p-8 space-y-4 shadow-sm">
                <div class="flex items-center gap-3 text-emerald-800 font-bold text-lg">
                    <div class="w-10 h-10 rounded-full bg-emerald-200 flex items-center justify-center text-emerald-800">
                        <i class="fa-solid fa-check text-xl"></i>
                    </div>
                    <span>{{ app()->getLocale() == 'bn' ? 'NutriDesk এর সমাধান' : 'The NutriDesk Solution' }}</span>
                </div>
                <ul class="space-y-3 text-sm text-slate-700">
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-circle-check text-emerald-600 mt-1"></i>
                        <span>{{ app()->getLocale() == 'bn' ? 'মাত্র ৪০-৫০ টাকায় প্রতিদিন ১০০-১২০ গ্রাম ফ্রেশ কাটা ফল ডেস্কে রেডি।' : 'Freshly sliced 100-150g fruit bowl delivered for just ৳40-50 per day.' }}</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-circle-check text-emerald-600 mt-1"></i>
                        <span>{{ app()->getLocale() == 'bn' ? 'হাইজিনিক ফুড-গ্রেড ওয়ান টাইম পাত্রে সরাসরি পৌঁছে দেওয়া হয়, কাটার কোনো ঝামেলা নেই।' : 'Hygienic, food-grade eco containers. Open and eat with included fork!' }}</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-circle-check text-emerald-600 mt-1"></i>
                        <span>{{ app()->getLocale() == 'bn' ? 'পুষ্টিবিদ নির্ধারিত দেশি ও বিদেশী ফলের বৈচিত্র্য এবং ডায়াবেটিক রোগীদের বিশেষ প্যাক।' : 'Dietitian curated fruit rotations with tailored boxes for diabetes & heart health.' }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Packages Section -->
<section id="packages" class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-emerald-600 font-bold uppercase tracking-widest text-xs mb-2 block">
                {{ app()->getLocale() == 'bn' ? 'সাশ্রয়ী সাবস্ক্রিপশন প্ল্যান' : 'Affordable Subscription Plans' }}
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-4">
                {{ app()->getLocale() == 'bn' ? 'আপনার প্রয়োজন অনুযায়ী প্যাকেজ বেছে নিন' : 'Choose Your Best Fit Package' }}
            </h2>
            <p class="text-slate-600 text-sm sm:text-base">
                {{ app()->getLocale() == 'bn' 
                    ? '১ জনের একক শক্তি প্যাক, কলিগদের বন্ধু প্যাক অথবা পুরো অফিস টিমের জন্য বিশেষ প্যাকেজ।' 
                    : 'Solo shakti pack, buddy packs for coworkers, or corporate trays for full teams.' }}
            </p>
        </div>

        <!-- Package Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
            @foreach($packages as $pkg)
                <div class="bg-white rounded-3xl border {{ $pkg->code === 'shakti' ? 'border-emerald-500 shadow-xl shadow-emerald-500/10 ring-2 ring-emerald-500' : 'border-slate-200 shadow-sm' }} p-8 flex flex-col justify-between relative overflow-hidden transition hover:-translate-y-1">
                    @if($pkg->badge_text)
                        <div class="absolute top-0 right-0 bg-emerald-600 text-white text-[11px] font-bold py-1 px-3.5 rounded-bl-xl uppercase tracking-wider">
                            {{ $pkg->badge_text }}
                        </div>
                    @endif

                    <div>
                        <!-- Icon & Title -->
                        <div class="w-14 h-14 rounded-2xl {{ $pkg->code === 'shakti' ? 'bg-emerald-100 text-emerald-700' : ($pkg->code === 'bondhu' ? 'bg-amber-100 text-amber-700' : 'bg-indigo-100 text-indigo-700') }} flex items-center justify-center text-2xl mb-6">
                            @if($pkg->code === 'shakti')
                                <i class="fa-solid fa-person-running"></i>
                            @elseif($pkg->code === 'bondhu')
                                <i class="fa-solid fa-user-group"></i>
                            @else
                                <i class="fa-solid fa-building"></i>
                            @endif
                        </div>

                        <h3 class="text-2xl font-bold text-slate-900 mb-2">
                            {{ app()->getLocale() == 'bn' ? $pkg->name_bn : $pkg->name_en }}
                        </h3>

                        <p class="text-xs text-slate-500 mb-6 min-h-[36px]">
                            {{ app()->getLocale() == 'bn' ? $pkg->description_bn : $pkg->description_en }}
                        </p>

                        <!-- Pricing Display -->
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 mb-6">
                            <div class="flex justify-between items-baseline mb-1">
                                <span class="text-xs text-slate-500">{{ app()->getLocale() == 'bn' ? '১ মাস (২২ কর্মদিবস):' : '1 Month (22 Workdays):' }}</span>
                                <span class="text-2xl font-black text-slate-900">৳{{ number_format($pkg->price_30_days, 0) }}</span>
                            </div>
                            <div class="flex justify-between items-baseline text-xs text-emerald-700 pt-2 border-t border-slate-200/60">
                                <span>{{ app()->getLocale() == 'bn' ? '৭ দিনের ট্রায়াল প্যাক:' : '7-Day Trial Pack:' }}</span>
                                <span class="font-bold text-sm">৳{{ number_format($pkg->price_7_days, 0) }}</span>
                            </div>
                            <div class="text-[11px] text-slate-400 text-right mt-1">
                                {{ app()->getLocale() == 'bn' ? 'মাথাপিছু মাত্র ৳' . $pkg->price_per_person_per_day . '/দিন' : 'Approx ৳' . $pkg->price_per_person_per_day . '/day per person' }}
                            </div>
                        </div>

                        <!-- Feature List -->
                        <ul class="space-y-3 mb-8 text-xs sm:text-sm text-slate-700">
                            @php
                                $features = app()->getLocale() == 'bn' ? ($pkg->features_bn ?? []) : ($pkg->features_en ?? []);
                            @endphp
                            @foreach($features as $feat)
                                <li class="flex items-start gap-2.5">
                                    <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5"></i>
                                    <span>{{ $feat }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Subscribe Button -->
                    <div>
                        <a href="{{ route('customer.checkout', $pkg->id) }}" class="w-full py-3.5 px-4 rounded-xl font-bold text-center block transition {{ $pkg->code === 'shakti' ? 'bg-emerald-600 text-white hover:bg-emerald-700 shadow-lg shadow-emerald-600/20' : 'bg-slate-900 text-white hover:bg-slate-800' }}">
                            {{ app()->getLocale() == 'bn' ? 'সাবস্ক্রাইব শুরু করুন' : 'Subscribe Now' }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Dietitian Weekly Rotation Menu Section -->
<section id="menu" class="py-20 bg-white border-y border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-6">
            <div>
                <span class="text-emerald-600 font-bold uppercase tracking-widest text-xs mb-2 block">
                    {{ app()->getLocale() == 'bn' ? 'পুষ্টিবিদ অনুমোদিত মেনু' : 'Nutritionist Approved Menu' }}
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">
                    {{ app()->getLocale() == 'bn' ? 'রবিবার থেকে বৃহস্পতিবার কি কি ফল থাকছে?' : 'What Fruits Are In Your Weekly Bowl?' }}
                </h2>
                <p class="text-slate-500 text-sm mt-2">
                    {{ app()->getLocale() == 'bn' ? 'প্রতিদিন একই ফল নয়; ৫ কর্মদিবসে থাকছে বৈচিত্র্যময় দেশি ও বিদেশি ফলের ব্যালেন্সড কম্বিনেশন।' : 'No repetitive monotony. Each day of the working week features a fresh balance of local and imported fruits.' }}
                </p>
            </div>
            <div class="flex items-center gap-2 bg-emerald-50 text-emerald-800 text-xs font-semibold px-4 py-2 rounded-xl border border-emerald-200">
                <i class="fa-solid fa-user-doctor text-emerald-600 text-base"></i>
                <span>{{ app()->getLocale() == 'bn' ? 'ডাঃ নুসরাত জাহান (প্রধান পুষ্টিবিদ)' : 'Dr. Nusrat Jahan (Lead Nutritionist)' }}</span>
            </div>
        </div>

        <!-- Weekly Day Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            @foreach($dietitianMenus as $menu)
                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200 hover:border-emerald-300 hover:bg-emerald-50/30 transition flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-center mb-3">
                            <span class="font-black text-sm uppercase tracking-wider text-emerald-800 bg-emerald-100 px-2.5 py-1 rounded-lg">
                                {{ strtoupper($menu->day_of_week) }}
                            </span>
                            <span class="text-xs text-slate-400 font-medium">{{ $menu->calories_total }} kcal</span>
                        </div>

                        <h4 class="font-bold text-slate-900 text-sm mb-3">
                            {{ app()->getLocale() == 'bn' ? $menu->title_bn : $menu->title_en }}
                        </h4>

                        <!-- Included Fruits List -->
                        <div class="space-y-1.5 mb-4">
                            @if(is_array($menu->fruits_list))
                                @foreach($menu->fruits_list as $item)
                                    <div class="flex justify-between text-xs text-slate-600 bg-white px-2 py-1.5 rounded-lg border border-slate-100">
                                        <span>{{ app()->getLocale() == 'bn' ? ($item['fruit_bn'] ?? $item['fruit']) : $item['fruit'] }}</span>
                                        <span class="font-bold text-slate-400">{{ $item['grams'] }}g</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Dietitian advice -->
                    <div class="text-[11px] text-emerald-700 bg-emerald-50 p-2.5 rounded-xl border border-emerald-100">
                        <i class="fa-solid fa-lightbulb mr-1 text-amber-500"></i>
                        <span>{{ app()->getLocale() == 'bn' ? $menu->dietitian_advice_bn : $menu->dietitian_advice_en }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Health Tailored Section (Diabetes, Kidney, Heart) -->
<section id="health" class="py-20 gradient-brand text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="bg-white/20 text-white font-bold uppercase tracking-widest text-xs px-3 py-1 rounded-full mb-3 inline-block">
                {{ app()->getLocale() == 'bn' ? 'বিশেষ স্বাস্থ্য সুবিধা' : 'Specialized Health Care' }}
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-4">
                {{ app()->getLocale() == 'bn' ? 'ডায়াবেটিস, কিডনি বা হার্টের সমস্যায় আলাদা ফল?' : 'Suffering from Diabetes, Kidney or Heart Issues?' }}
            </h2>
            <p class="text-emerald-100 text-sm sm:text-base">
                {{ app()->getLocale() == 'bn' 
                    ? 'হ্যাঁ! আমাদের পুষ্টিবিদ রোগীদের জন্য ফল আলাদা করে দেন। আপনি চেকআউটে আপনার স্বাস্থ্য সমস্যা নির্বাচন করলেই নিরাপদ ফল আপনার বক্সে যাবে।'
                    : 'Yes! Our clinical nutritionists pre-screen each fruit bowl. Simply select your health condition during subscription checkout.' }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Diabetes Care -->
            <div class="bg-white/10 backdrop-blur border border-white/20 rounded-3xl p-8 hover:bg-white/15 transition">
                <div class="w-12 h-12 rounded-xl bg-amber-400 text-slate-900 flex items-center justify-center text-xl mb-6 font-bold">
                    <i class="fa-solid fa-droplet"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">{{ app()->getLocale() == 'bn' ? 'ডায়াবেটিস কেয়ার ফ্রুট বাউল' : 'Diabetes Care Fruit Bowl' }}</h3>
                <p class="text-xs text-emerald-100 mb-4 leading-relaxed">
                    {{ app()->getLocale() == 'bn' 
                        ? 'কম গ্লাইসেমিক ইনডেক্স (Low-GI) যুক্ত ফল যেমন সবুজ নাশপাতি, থাই পেয়ারা, ফুজি আপেল ও ড্রাগন ফল দেওয়া হয় যা রক্তে সুগার বাড়ায় না।'
                        : 'Strictly low-glycemic fruits (Guava, Green Pear, Apple, Dragon Fruit) that maintain steady glucose levels without insulin spikes.' }}
                </p>
                <span class="inline-block bg-amber-400/20 text-amber-200 text-xs font-semibold px-2.5 py-1 rounded-md">
                    Low Sugar & High Soluble Fiber
                </span>
            </div>

            <!-- Kidney Friendly -->
            <div class="bg-white/10 backdrop-blur border border-white/20 rounded-3xl p-8 hover:bg-white/15 transition">
                <div class="w-12 h-12 rounded-xl bg-sky-400 text-slate-900 flex items-center justify-center text-xl mb-6 font-bold">
                    <i class="fa-solid fa-heart-pulse"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">{{ app()->getLocale() == 'bn' ? 'কিডনি ফ্রেন্ডলি ফ্রুট বাউল' : 'Kidney Friendly Fruit Bowl' }}</h3>
                <p class="text-xs text-emerald-100 mb-4 leading-relaxed">
                    {{ app()->getLocale() == 'bn' 
                        ? 'কম পটাশিয়াম ও কম ফসফরাসযুক্ত ফল নির্বাচন করা হয়। কলা বা অতিরিক্ত পটাশিয়ামযুক্ত ফল বর্জন করে নিরাপদ ফল পরিবেশন করা হয়।'
                        : 'Low potassium and controlled mineral fruits to keep kidney load minimal while nourishing essential hydration.' }}
                </p>
                <span class="inline-block bg-sky-400/20 text-sky-200 text-xs font-semibold px-2.5 py-1 rounded-md">
                    Low Potassium (Under 200mg/100g)
                </span>
            </div>

            <!-- Heart Care -->
            <div class="bg-white/10 backdrop-blur border border-white/20 rounded-3xl p-8 hover:bg-white/15 transition">
                <div class="w-12 h-12 rounded-xl bg-rose-400 text-slate-900 flex items-center justify-center text-xl mb-6 font-bold">
                    <i class="fa-solid fa-shield-heart"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">{{ app()->getLocale() == 'bn' ? 'হার্ট কেয়ার অ্যান্টিঅক্সিডেন্ট প্যাক' : 'Cardio Antioxidant Pack' }}</h3>
                <p class="text-xs text-emerald-100 mb-4 leading-relaxed">
                    {{ app()->getLocale() == 'bn' 
                        ? 'বেদানা, লাল ড্রাগন এবং সাইট্রাস মাল্টা যাতে রয়েছে প্রচুর পলিফেনল ও অ্যান্টিঅক্সিডেন্ট, রক্তচাপ ও কোলেস্টেরল নিয়ন্ত্রণে সহায়ক।'
                        : 'Pomegranate arils, red dragon fruit and citrus rich in polyphenols that strengthen blood vessels and cardiovascular vigor.' }}
                </p>
                <span class="inline-block bg-rose-400/20 text-rose-200 text-xs font-semibold px-2.5 py-1 rounded-md">
                    High Polyphenols & Flavonoids
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Pause / Skip Feature Highlight -->
<section id="how-it-works" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-emerald-50 via-teal-50 to-slate-50 border border-emerald-200 rounded-3xl p-8 sm:p-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-8 space-y-4">
                    <span class="text-emerald-700 font-bold uppercase tracking-wider text-xs">
                        {{ app()->getLocale() == 'bn' ? 'স্মার্ট ও সহজ সাবস্ক্রিপশন' : 'Smart & Flexible Subscription' }}
                    </span>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                        {{ app()->getLocale() == 'bn' ? 'অফিসে ছুটি থাকলে ডেলিভারি পজ (Pause) করুন, টাকা নষ্ট হবে না!' : 'Going on Leave? Pause Your Delivery in 1-Click!' }}
                    </h3>
                    <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                        {{ app()->getLocale() == 'bn'
                            ? 'যদি কোনো দিন আপনার অফিস ছুটি থাকে বা মিটিংয়ে বাইরে থাকেন, আগের দিন রাত ১০টার মধ্যে অ্যাপ বা ওয়েবসাইট থেকে নির্দিষ্ট দিনটি "Pause" করুন। সেই দিনের ফলের ব্যালেন্স আপনার সাবস্ক্রিপশনের মেয়াদ শেষে অতিরিক্ত দিন হিসেবে স্বয়ংক্রিয়ভাবে যোগ হয়ে যাবে।'
                            : 'If you have an office off-day, annual leave, or external client meeting, simply tap "Pause" before 10 PM. That day will automatically extend to the end of your billing cycle. You never lose a single bowl!' }}
                    </p>
                </div>
                <div class="lg:col-span-4 flex justify-center">
                    <div class="bg-white p-6 rounded-2xl shadow-lg border border-emerald-100 text-center w-full max-w-xs">
                        <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl mx-auto mb-3">
                            <i class="fa-solid fa-circle-pause"></i>
                        </div>
                        <h4 class="font-bold text-slate-900 text-base mb-1">{{ app()->getLocale() == 'bn' ? '১-ক্লিক পজ ও রিজিউম' : '1-Click Pause & Resume' }}</h4>
                        <p class="text-xs text-slate-500 mb-4">{{ app()->getLocale() == 'bn' ? 'ড্যাশবোর্ড ক্যালেন্ডার থেকে সহজে পরিচালনা করুন' : 'Manage easily from your customer calendar' }}</p>
                        <a href="#packages" class="bg-emerald-600 text-white font-bold text-xs py-2.5 px-4 rounded-xl block hover:bg-emerald-700 transition">
                            {{ app()->getLocale() == 'bn' ? 'আজই শুরু করুন' : 'Start Today' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
