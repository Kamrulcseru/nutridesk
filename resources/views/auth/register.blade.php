@extends('layouts.app')

@section('content')
<div class="py-16 bg-slate-50 flex items-center justify-center min-h-[75vh]">
    <div class="max-w-xl w-full mx-auto px-4">
        <div class="bg-white rounded-3xl border border-slate-200/80 p-8 shadow-xl space-y-6">
            <div class="text-center space-y-2">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-emerald-500 to-amber-400 flex items-center justify-center text-white text-2xl mx-auto shadow-md">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
                <h2 class="text-2xl font-extrabold text-slate-900">
                    {{ app()->getLocale() == 'bn' ? 'NutriDesk এ নতুন অ্যাকাউন্ট' : 'Register for NutriDesk' }}
                </h2>
                <p class="text-xs text-slate-500">
                    {{ app()->getLocale() == 'bn' ? 'অফিস কর্মীদের জন্য স্বাস্থ্যকর ফ্রুট সাবস্ক্রিপশন প্ল্যাটফর্ম' : 'The healthy office fruit delivery platform' }}
                </p>
            </div>

            <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            {{ app()->getLocale() == 'bn' ? 'আপনার নাম *' : 'Full Name *' }}
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            {{ app()->getLocale() == 'bn' ? 'মোবাইল নম্বর *' : 'Phone Number *' }}
                        </label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="+88017XXXXXXXX" class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        {{ app()->getLocale() == 'bn' ? 'ইমেইল এড্রেস *' : 'Email Address *' }}
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            {{ app()->getLocale() == 'bn' ? 'পাসওয়ার্ড *' : 'Password *' }}
                        </label>
                        <input type="password" name="password" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            {{ app()->getLocale() == 'bn' ? 'পাসওয়ার্ড নিশ্চিত করুন *' : 'Confirm Password *' }}
                        </label>
                        <input type="password" name="password_confirmation" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            {{ app()->getLocale() == 'bn' ? 'কোম্পানি / অফিসের নাম' : 'Office / Company Name' }}
                        </label>
                        <input type="text" name="office_name" value="{{ old('office_name') }}" placeholder="e.g. Grameenphone / BRAC" class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            {{ app()->getLocale() == 'bn' ? 'স্বাস্থ্য / ডায়েট প্রোফাইল' : 'Health / Dietary Profile' }}
                        </label>
                        <select name="health_condition" class="w-full text-xs rounded-xl border-slate-200 p-2.5 border font-semibold">
                            <option value="general">{{ app()->getLocale() == 'bn' ? 'সাধারণ ফিটনেস (সব ফল)' : 'General Fitness' }}</option>
                            <option value="diabetes">{{ app()->getLocale() == 'bn' ? 'ডায়াবেটিস কেয়ার (লো জিআই ফল)' : 'Diabetes Care (Low GI)' }}</option>
                            <option value="kidney">{{ app()->getLocale() == 'bn' ? 'কিডনি কেয়ার (লো পটাশিয়াম)' : 'Kidney Care (Low Potassium)' }}</option>
                            <option value="heart">{{ app()->getLocale() == 'bn' ? 'হার্ট কেয়ার (অ্যান্টিঅক্সিডেন্ট)' : 'Heart Care' }}</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() == 'bn' ? 'ফ্লোর' : 'Floor' }}</label>
                        <input type="text" name="office_floor" value="{{ old('office_floor') }}" placeholder="e.g. 6th Floor" class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() == 'bn' ? 'ডেস্ক নম্বর' : 'Desk Number' }}</label>
                        <input type="text" name="desk_number" value="{{ old('desk_number') }}" placeholder="e.g. Desk #12" class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
                    </div>
                </div>

                <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-emerald-600/20 transition">
                    {{ app()->getLocale() == 'bn' ? 'অ্যাকাউন্ট তৈরি করুন' : 'Create Account' }}
                </button>
            </form>

            <p class="text-center text-xs text-slate-500 pt-2">
                {{ app()->getLocale() == 'bn' ? 'ইতিমধ্যে অ্যাকাউন্ট আছে?' : 'Already have an account?' }}
                <a href="{{ route('login') }}" class="text-emerald-700 font-bold hover:underline">
                    {{ app()->getLocale() == 'bn' ? 'লগইন করুন' : 'Sign In' }}
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
