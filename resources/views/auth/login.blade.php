@extends('layouts.app')

@section('content')
<div class="py-16 bg-slate-50 flex items-center justify-center min-h-[75vh]">
    <div class="max-w-md w-full mx-auto px-4">
        <div class="bg-white rounded-3xl border border-slate-200/80 p-8 shadow-xl space-y-6">
            <div class="text-center space-y-2">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-emerald-500 to-amber-400 flex items-center justify-center text-white text-2xl mx-auto shadow-md">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <h2 class="text-2xl font-extrabold text-slate-900">
                    {{ app()->getLocale() == 'bn' ? 'নিউট্রিডেস্কে লগইন করুন' : 'Sign in to NutriDesk' }}
                </h2>
                <p class="text-xs text-slate-500">
                    {{ app()->getLocale() == 'bn' ? 'আপনার অফিস ডেস্কে ফলের সাবস্ক্রিপশন পরিচালনা করুন' : 'Manage your office desk subscriptions and orders' }}
                </p>
            </div>

            <!-- Login Form -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        {{ app()->getLocale() == 'bn' ? 'ইমেইল এড্রেস' : 'Email Address' }}
                    </label>
                    <input type="email" name="email" id="emailInput" value="{{ old('email') }}" required autofocus class="w-full text-sm rounded-xl border-slate-200 p-2.5 border focus:border-emerald-500 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        {{ app()->getLocale() == 'bn' ? 'পাসওয়ার্ড' : 'Password' }}
                    </label>
                    <input type="password" name="password" id="passwordInput" required class="w-full text-sm rounded-xl border-slate-200 p-2.5 border focus:border-emerald-500 focus:ring-emerald-500">
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-1.5 cursor-pointer text-slate-600">
                        <input type="checkbox" name="remember" class="rounded text-emerald-600">
                        <span>{{ app()->getLocale() == 'bn' ? 'স্মরণ রাখুন' : 'Remember me' }}</span>
                    </label>
                    <a href="#" class="text-emerald-700 hover:underline font-semibold">Forgot?</a>
                </div>

                <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-emerald-600/20 transition">
                    {{ app()->getLocale() == 'bn' ? 'লগইন করুন' : 'Sign In' }}
                </button>
            </form>

            <!-- 1-Click Demo Logins for Quick Testing -->
            <div class="border-t border-slate-100 pt-5 space-y-2.5">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block text-center">
                    {{ app()->getLocale() == 'bn' ? 'দ্রুত টেস্ট করার জন্য ডেমো অ্যাকাউন্ট' : 'Quick Demo One-Click Login' }}
                </span>

                <div class="grid grid-cols-3 gap-2">
                    <button type="button" onclick="fillCreds('admin@nutridesk.com', 'admin123')" class="py-2 px-2 rounded-xl bg-amber-50 hover:bg-amber-100 border border-amber-200 text-amber-900 text-[11px] font-bold text-center transition">
                        Super Admin
                    </button>
                    <button type="button" onclick="fillCreds('staff@nutridesk.com', 'staff123')" class="py-2 px-2 rounded-xl bg-blue-50 hover:bg-blue-100 border border-blue-200 text-blue-900 text-[11px] font-bold text-center transition">
                        Staff / Ops
                    </button>
                    <button type="button" onclick="fillCreds('tanvir@techcorp.com', 'user123')" class="py-2 px-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-emerald-900 text-[11px] font-bold text-center transition">
                        Customer
                    </button>
                </div>
            </div>

            <p class="text-center text-xs text-slate-500 pt-2">
                {{ app()->getLocale() == 'bn' ? 'নতুন গ্রাহক?' : 'New here?' }}
                <a href="{{ route('register') }}" class="text-emerald-700 font-bold hover:underline">
                    {{ app()->getLocale() == 'bn' ? 'নতুন অ্যাকাউন্ট খুলুন' : 'Create an Account' }}
                </a>
            </p>
        </div>
    </div>
</div>

<script>
    function fillCreds(email, password) {
        document.getElementById('emailInput').value = email;
        document.getElementById('passwordInput').value = password;
    }
</script>
@endsection
