@extends('layouts.app')

@section('content')
<div class="py-12 bg-slate-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb / Header -->
        <div class="mb-8">
            <a href="{{ route('home') }}#packages" class="text-xs text-emerald-700 hover:underline flex items-center gap-1.5 mb-2 font-medium">
                <i class="fa-solid fa-arrow-left"></i>
                <span>{{ app()->getLocale() == 'bn' ? 'প্যাকেজে ফিরে যান' : 'Back to Packages' }}</span>
            </a>
            <h1 class="text-3xl font-extrabold text-slate-900">
                {{ app()->getLocale() == 'bn' ? 'সাবস্ক্রিপশন সম্পন্ন করুন' : 'Complete Your Fruit Subscription' }}
            </h1>
            <p class="text-slate-500 text-sm">
                {{ app()->getLocale() == 'bn' ? 'আপনার অফিস ডেস্কে প্রতিদিন সময়মতো ফ্রেশ ফল পৌঁছে দেওয়ার বিস্তারিত তথ্য দিন।' : 'Provide your office delivery desk and health preferences below.' }}
            </p>
        </div>

        <form action="{{ route('customer.checkout.process') }}" method="POST" id="checkoutForm">
            @csrf
            <input type="hidden" name="package_id" value="{{ $package->id }}">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- Left Form Columns -->
                <div class="lg:col-span-7 space-y-6">

                    <!-- Plan Duration Selection (7-Day vs 30-Day) -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                        <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                            <i class="fa-solid fa-calendar text-emerald-600"></i>
                            <span>{{ app()->getLocale() == 'bn' ? '১. মেয়াদের ধরণ নির্বাচন করুন' : '1. Choose Duration' }}</span>
                        </h3>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- 7-Day Trial -->
                            <label class="cursor-pointer border-2 rounded-2xl p-4 flex flex-col justify-between transition border-slate-200 hover:border-emerald-400 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50">
                                <div class="flex justify-between items-start">
                                    <span class="font-bold text-slate-900 text-sm sm:text-base">{{ app()->getLocale() == 'bn' ? '৭ দিনের ট্রায়াল প্যাক' : '7-Day Trial' }}</span>
                                    <input type="radio" name="plan_duration" value="7_days" class="text-emerald-600" onchange="updateSummary()" {{ old('plan_duration') == '7_days' ? 'checked' : '' }}>
                                </div>
                                <span class="text-xs text-slate-500 mt-2 block">{{ app()->getLocale() == 'bn' ? '৫ কর্মদিবস ডেলিভারি' : '5 Workdays' }}</span>
                                <span class="text-emerald-700 font-black text-lg mt-2">৳{{ number_format($package->price_7_days, 0) }}</span>
                            </label>

                            <!-- 30-Day Regular -->
                            <label class="cursor-pointer border-2 rounded-2xl p-4 flex flex-col justify-between transition border-emerald-600 bg-emerald-50/50 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50">
                                <div class="flex justify-between items-start">
                                    <span class="font-bold text-slate-900 text-sm sm:text-base">{{ app()->getLocale() == 'bn' ? '১ মাসের নিয়মিত প্যাক' : '1 Month Regular' }}</span>
                                    <input type="radio" name="plan_duration" value="30_days" class="text-emerald-600" onchange="updateSummary()" checked>
                                </div>
                                <span class="text-xs text-slate-500 mt-2 block">{{ app()->getLocale() == 'bn' ? '২২ কর্মদিবস ডেলিভারি' : '22 Workdays' }}</span>
                                <span class="text-emerald-700 font-black text-lg mt-2">৳{{ number_format($package->price_30_days, 0) }}</span>
                            </label>
                        </div>
                    </div>

                    <!-- Health Condition Preference -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                        <div class="flex justify-between items-center">
                            <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                                <i class="fa-solid fa-heart-pulse text-rose-500"></i>
                                <span>{{ app()->getLocale() == 'bn' ? '২. স্বাস্থ্য ও ডায়েট প্রোফাইল' : '2. Health Profile & Dietary Need' }}</span>
                            </h3>
                            <span class="text-[11px] bg-rose-50 text-rose-700 font-bold px-2 py-0.5 rounded border border-rose-200">
                                {{ app()->getLocale() == 'bn' ? 'পুষ্টিবিদ নজরদারি' : 'Dietitian Supervised' }}
                            </span>
                        </div>

                        <p class="text-xs text-slate-500">
                            {{ app()->getLocale() == 'bn' ? 'রোগীদের জন্য ফল পরিবর্তন করা হবে। আপনার স্বাস্থ্য অনুযায়ী সিলেক্ট করুন:' : 'Fruits are custom sorted based on medical dietary safety:' }}
                        </p>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <label class="cursor-pointer border rounded-xl p-3 text-center transition border-slate-200 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/60">
                                <input type="radio" name="health_condition" value="general" class="hidden" checked>
                                <i class="fa-solid fa-shield-virus text-emerald-600 text-lg mb-1 block"></i>
                                <span class="text-xs font-bold block text-slate-800">{{ app()->getLocale() == 'bn' ? 'সাধারণ ফিটনেস' : 'General Fitness' }}</span>
                                <span class="text-[10px] text-slate-400">{{ app()->getLocale() == 'bn' ? 'সকল ফল মিক্স' : 'All Fruit Mix' }}</span>
                            </label>

                            <label class="cursor-pointer border rounded-xl p-3 text-center transition border-slate-200 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/60">
                                <input type="radio" name="health_condition" value="diabetes" class="hidden" {{ (auth()->user()->health_condition ?? '') === 'diabetes' ? 'checked' : '' }}>
                                <i class="fa-solid fa-droplet text-amber-500 text-lg mb-1 block"></i>
                                <span class="text-xs font-bold block text-slate-800">{{ app()->getLocale() == 'bn' ? 'ডায়াবেটিস কেয়ার' : 'Diabetes Care' }}</span>
                                <span class="text-[10px] text-slate-400">Low-GI Only</span>
                            </label>

                            <label class="cursor-pointer border rounded-xl p-3 text-center transition border-slate-200 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/60">
                                <input type="radio" name="health_condition" value="kidney" class="hidden" {{ (auth()->user()->health_condition ?? '') === 'kidney' ? 'checked' : '' }}>
                                <i class="fa-solid fa-virus text-sky-500 text-lg mb-1 block"></i>
                                <span class="text-xs font-bold block text-slate-800">{{ app()->getLocale() == 'bn' ? 'কিডনি কেয়ার' : 'Kidney Care' }}</span>
                                <span class="text-[10px] text-slate-400">Low Potassium</span>
                            </label>

                            <label class="cursor-pointer border rounded-xl p-3 text-center transition border-slate-200 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/60">
                                <input type="radio" name="health_condition" value="heart" class="hidden" {{ (auth()->user()->health_condition ?? '') === 'heart' ? 'checked' : '' }}>
                                <i class="fa-solid fa-heart text-rose-500 text-lg mb-1 block"></i>
                                <span class="text-xs font-bold block text-slate-800">{{ app()->getLocale() == 'bn' ? 'হার্ট কেয়ার' : 'Heart Care' }}</span>
                                <span class="text-[10px] text-slate-400">Antioxidants</span>
                            </label>
                        </div>
                    </div>

                    <!-- Office Delivery Address Details -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                        <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                            <i class="fa-solid fa-building text-indigo-600"></i>
                            <span>{{ app()->getLocale() == 'bn' ? '৩. অফিস ডেলিভারি লোকেশন' : '3. Office Desk Location' }}</span>
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() == 'bn' ? 'কোম্পানি / অফিসের নাম *' : 'Office / Company Name *' }}</label>
                                <input type="text" name="delivery_office_name" value="{{ old('delivery_office_name', auth()->user()->office_name ?? '') }}" required placeholder="e.g. Brain Station 23 / Grameenphone" class="w-full text-sm rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 p-2.5 border">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() == 'bn' ? 'ডেলিভারি মোবাইল নম্বর *' : 'Delivery Phone *' }}</label>
                                <input type="text" name="delivery_phone" value="{{ old('delivery_phone', auth()->user()->phone ?? '') }}" required placeholder="+88017XXXXXXXX" class="w-full text-sm rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 p-2.5 border">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() == 'bn' ? 'অফিসের পূর্ণ ঠিকানা / এলাকা *' : 'Office Address / Area *' }}</label>
                            <input type="text" name="delivery_office_address" value="{{ old('delivery_office_address', auth()->user()->office_address ?? '') }}" required placeholder="e.g. Plot 2, Block B, Gulshan 2, Dhaka" class="w-full text-sm rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 p-2.5 border">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() == 'bn' ? 'ফ্লোর / লিফট' : 'Floor / Level' }}</label>
                                <input type="text" name="delivery_floor" value="{{ old('delivery_floor', auth()->user()->office_floor ?? '') }}" placeholder="e.g. 5th Floor" class="w-full text-sm rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 p-2.5 border">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() == 'bn' ? 'ডেস্ক বা কেবিন নম্বর' : 'Desk / Cabin Number' }}</label>
                                <input type="text" name="delivery_desk" value="{{ old('delivery_desk', auth()->user()->desk_number ?? '') }}" placeholder="e.g. Desk #42 (IT Team)" class="w-full text-sm rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 p-2.5 border">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() == 'bn' ? 'ডেলিভারির সময় স্লট' : 'Delivery Slot' }}</label>
                                <select name="delivery_time_slot" class="w-full text-sm rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 p-2.5 border">
                                    <option value="09:30 AM - 10:30 AM">09:30 AM - 10:30 AM (সকালের স্লট)</option>
                                    <option value="10:30 AM - 11:30 AM" selected>10:30 AM - 11:30 AM (টি-টাইম স্লট - সেরা)</option>
                                    <option value="11:30 AM - 12:30 PM">11:30 AM - 12:30 PM (লাঞ্চের পূর্বে)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() == 'bn' ? 'শুরুর তারিখ (রবি-বৃহস্পতি)' : 'Start Date' }}</label>
                                <input type="date" name="start_date" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required class="w-full text-sm rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 p-2.5 border">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() == 'bn' ? 'বিশেষ নির্দেশনা বা এলার্জি (যদি থাকে)' : 'Special Notes / Allergies' }}</label>
                            <textarea name="special_notes" rows="2" placeholder="e.g. পেয়ারা খেলে সমস্যা নেই কিন্তু আনারসে এলার্জি আছে..." class="w-full text-sm rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 p-2.5 border"></textarea>
                        </div>
                    </div>

                    <!-- Payment Method Selection -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                        <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                            <i class="fa-solid fa-credit-card text-emerald-600"></i>
                            <span>{{ app()->getLocale() == 'bn' ? '৪. পেমেন্ট পদ্ধতি বেছে নিন' : '4. Payment Method' }}</span>
                        </h3>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <label class="cursor-pointer border-2 rounded-2xl p-3 text-center transition border-slate-200 has-[:checked]:border-pink-600 has-[:checked]:bg-pink-50/50">
                                <input type="radio" name="payment_method" value="bkash" class="hidden" checked>
                                <div class="w-8 h-8 rounded-lg bg-pink-100 text-pink-600 font-black flex items-center justify-center mx-auto mb-1 text-xs">bK</div>
                                <span class="text-xs font-bold block text-slate-800">bKash</span>
                                <span class="text-[10px] text-slate-400">বিকাশ অনলাইন</span>
                            </label>

                            <label class="cursor-pointer border-2 rounded-2xl p-3 text-center transition border-slate-200 has-[:checked]:border-orange-600 has-[:checked]:bg-orange-50/50">
                                <input type="radio" name="payment_method" value="nagad" class="hidden">
                                <div class="w-8 h-8 rounded-lg bg-orange-100 text-orange-600 font-black flex items-center justify-center mx-auto mb-1 text-xs">NG</div>
                                <span class="text-xs font-bold block text-slate-800">Nagad</span>
                                <span class="text-[10px] text-slate-400">নগদ ওয়ালেট</span>
                            </label>

                            <label class="cursor-pointer border-2 rounded-2xl p-3 text-center transition border-slate-200 has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/50">
                                <input type="radio" name="payment_method" value="card" class="hidden">
                                <i class="fa-solid fa-credit-card text-indigo-600 text-xl mb-1 block"></i>
                                <span class="text-xs font-bold block text-slate-800">Card</span>
                                <span class="text-[10px] text-slate-400">Visa / Master</span>
                            </label>

                            <label class="cursor-pointer border-2 rounded-2xl p-3 text-center transition border-slate-200 has-[:checked]:border-slate-800 has-[:checked]:bg-slate-50">
                                <input type="radio" name="payment_method" value="corporate_invoice" class="hidden">
                                <i class="fa-solid fa-file-invoice-dollar text-slate-700 text-xl mb-1 block"></i>
                                <span class="text-xs font-bold block text-slate-800">Invoice</span>
                                <span class="text-[10px] text-slate-400">মান্থলি বিল</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar: Order Summary & Confirmation -->
                <div class="lg:col-span-5 sticky top-28">
                    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-xl space-y-6">
                        <div class="border-b border-slate-100 pb-4">
                            <span class="text-xs font-bold uppercase tracking-wider text-emerald-600">অর্ডার সামারি / Summary</span>
                            <h2 class="text-xl font-extrabold text-slate-900 mt-1">
                                {{ app()->getLocale() == 'bn' ? $package->name_bn : $package->name_en }}
                            </h2>
                            <p class="text-xs text-slate-500 mt-1">
                                {{ app()->getLocale() == 'bn' ? 'প্রতিদিন ' . $package->grams_per_person_daily . ' গ্রাম ফ্রেশ কাটা ফল' : 'Daily ' . $package->grams_per_person_daily . 'g fresh fruit bowl' }}
                            </p>
                        </div>

                        <!-- Number of persons input -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">
                                {{ app()->getLocale() == 'bn' ? 'কত জনের জন্য? (Persons)' : 'Total Persons' }}
                            </label>
                            <input type="number" name="total_persons" id="totalPersons" value="{{ $package->min_persons }}" min="{{ $package->min_persons }}" max="{{ $package->max_persons > 4 ? 50 : $package->max_persons }}" class="w-full text-sm rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 p-2.5 border" onchange="updateSummary()">
                            <span class="text-[11px] text-slate-400 mt-1 block">
                                {{ app()->getLocale() == 'bn' ? 'প্যাকেজ রেঞ্জ: ' . $package->min_persons . ' - ' . $package->max_persons . ' জন' : 'Allowed range: ' . $package->min_persons . ' - ' . $package->max_persons }}
                            </span>
                        </div>

                        <!-- Live Cost Calculation -->
                        <div class="space-y-3 text-sm text-slate-600 border-t border-slate-100 pt-4">
                            <div class="flex justify-between">
                                <span>{{ app()->getLocale() == 'bn' ? 'বেস প্যাকেজ মূল্য:' : 'Base Price:' }}</span>
                                <span id="displayBasePrice" class="font-bold text-slate-900">৳{{ number_format($package->price_30_days, 0) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>{{ app()->getLocale() == 'bn' ? 'ডেস্ক ডেলিভারি ফি:' : 'Desk Delivery:' }}</span>
                                <span class="font-bold text-emerald-600 uppercase text-xs">{{ app()->getLocale() == 'bn' ? 'ফ্রি / FREE' : 'FREE' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>{{ app()->getLocale() == 'bn' ? 'ফুড-গ্রেড প্যাকেজিং ও ফর্ক:' : 'Eco Packaging & Fork:' }}</span>
                                <span class="font-bold text-emerald-600 uppercase text-xs">{{ app()->getLocale() == 'bn' ? 'ফ্রি / FREE' : 'FREE' }}</span>
                            </div>
                            <div class="flex justify-between text-base border-t border-slate-200 pt-3 text-slate-900 font-extrabold">
                                <span>{{ app()->getLocale() == 'bn' ? 'মোট প্রদেয়:' : 'Total Payable:' }}</span>
                                <span id="displayTotalPrice" class="text-2xl text-emerald-600 font-black">৳{{ number_format($package->price_30_days, 0) }}</span>
                            </div>
                        </div>

                        <!-- Safe Guarantee Notice -->
                        <div class="bg-emerald-50 p-3.5 rounded-2xl border border-emerald-100 text-xs text-emerald-800 space-y-1">
                            <div class="flex items-center gap-1.5 font-bold">
                                <i class="fa-solid fa-calendar-check text-emerald-600"></i>
                                <span>{{ app()->getLocale() == 'bn' ? 'পজ ও রোল-ওভার গ্যারান্টি' : 'Pause & Rollover Guarantee' }}</span>
                            </div>
                            <p class="text-[11px] leading-relaxed">
                                {{ app()->getLocale() == 'bn' ? 'ছুটির দিনে ডেলিভারি পজ করলে মেয়াদের সাথে সেই দিনগুলো স্বয়ংক্রিয়ভাবে যোগ হবে।' : 'Any days you pause due to holiday will be carried over to future delivery dates.' }}
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full py-4 rounded-2xl bg-emerald-600 text-white font-bold text-base hover:bg-emerald-700 shadow-xl shadow-emerald-600/30 transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-lock"></i>
                            <span>{{ app()->getLocale() == 'bn' ? 'অর্ডার নিশ্চিত করুন' : 'Confirm Subscription' }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const price7Days = {{ $package->price_7_days }};
    const price30Days = {{ $package->price_30_days }};
    const maxPersons = {{ $package->max_persons }};

    function updateSummary() {
        const duration = document.querySelector('input[name="plan_duration"]:checked').value;
        const personsInput = document.getElementById('totalPersons');
        const persons = parseInt(personsInput.value) || 1;

        let basePrice = duration === '7_days' ? price7Days : price30Days;
        let multiplier = persons > maxPersons ? (persons / Math.max(maxPersons, 1)) : 1;
        let total = Math.round(basePrice * multiplier);

        document.getElementById('displayBasePrice').textContent = '৳' + basePrice.toLocaleString();
        document.getElementById('displayTotalPrice').textContent = '৳' + total.toLocaleString();
    }
</script>
@endsection
