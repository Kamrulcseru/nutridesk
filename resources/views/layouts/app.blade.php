<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'NutriDesk') }} - {{ app()->getLocale() == 'bn' ? 'অফিস কর্মীদের জন্য প্রতিদিনের পুষ্টিকর ফ্রেশ ফল' : 'Fresh Daily Office Fruit Subscription' }}</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts: Hind Siliguri for Bengali + Outfit for English -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Hind Siliguri', 'Outfit', sans-serif;
        }
        .gradient-brand {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        }
        .gradient-hero {
            background: linear-gradient(135deg, #ECFDF5 0%, #FEF3C7 50%, #F0FDF4 100%);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen">

    <!-- Top Announcement Bar -->
    <div class="bg-emerald-900 text-emerald-100 text-xs sm:text-sm py-2 px-4 text-center font-medium flex justify-between items-center max-w-7xl mx-auto w-full">
        <div class="flex items-center gap-2 mx-auto sm:mx-0">
            <span class="bg-amber-400 text-amber-950 font-bold px-2 py-0.5 rounded text-xs">অফার / OFFER</span>
            <span>{{ app()->getLocale() == 'bn' ? 'প্রথম ৭ দিনের ট্রায়াল প্যাকে ২০% বিশেষ ছাড়! কোড: HEALTHYDESK' : 'Get 20% OFF on 7-Day Trial Pack! Code: HEALTHYDESK' }}</span>
        </div>
        <div class="hidden sm:flex items-center gap-4">
            <!-- Language Switcher -->
            <div class="flex items-center bg-emerald-800/80 rounded-full p-1 text-xs">
                <a href="{{ route('set.locale', 'bn') }}" class="px-2.5 py-0.5 rounded-full {{ app()->getLocale() == 'bn' ? 'bg-emerald-500 text-white font-bold' : 'text-emerald-200 hover:text-white' }}">বাংলা</a>
                <a href="{{ route('set.locale', 'en') }}" class="px-2.5 py-0.5 rounded-full {{ app()->getLocale() == 'en' ? 'bg-emerald-500 text-white font-bold' : 'text-emerald-200 hover:text-white' }}">English</a>
            </div>
            <span><i class="fa-solid fa-phone text-emerald-400 mr-1"></i> +8801646-696247</span>
        </div>
    </div>

    <!-- Navigation Bar -->
    <header class="bg-white/95 backdrop-blur shadow-sm sticky top-0 z-50 border-b border-emerald-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-500 to-amber-400 flex items-center justify-center text-white shadow-lg shadow-emerald-500/20">
                        <i class="fa-solid fa-apple-whole text-2xl"></i>
                    </div>
                    <div>
                        <span class="text-2xl font-black tracking-tight text-emerald-950">Nutri<span class="text-emerald-600">Desk</span></span>
                        <p class="text-xs text-emerald-700 font-medium -mt-1">{{ app()->getLocale() == 'bn' ? 'ডেস্কে প্রতিদিন ১০০ গ্রাম ফ্রেশ ফল' : 'Daily 100g Fruit At Your Desk' }}</p>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-700">
                    <a href="{{ route('home') }}#packages" class="hover:text-emerald-600 transition">{{ app()->getLocale() == 'bn' ? 'প্যাকেজসমূহ' : 'Packages' }}</a>
                    <a href="{{ route('home') }}#how-it-works" class="hover:text-emerald-600 transition">{{ app()->getLocale() == 'bn' ? 'কীভাবে কাজ করে' : 'How It Works' }}</a>
                    <a href="{{ route('home') }}#menu" class="hover:text-emerald-600 transition">{{ app()->getLocale() == 'bn' ? 'সাপ্তাহিক পুষ্টি চার্ট' : 'Dietitian Menu' }}</a>
                    <a href="{{ route('home') }}#health" class="hover:text-emerald-600 transition">{{ app()->getLocale() == 'bn' ? 'ডায়াবেটিস ও স্পেশাল কেয়ার' : 'Health Tailored' }}</a>
                </nav>

                <!-- Auth & Action Buttons -->
                <div class="flex items-center gap-3">
                    <!-- Mobile Language Switch -->
                    <div class="sm:hidden flex items-center bg-slate-100 rounded-lg p-0.5 text-xs">
                        <a href="{{ route('set.locale', 'bn') }}" class="px-2 py-1 rounded {{ app()->getLocale() == 'bn' ? 'bg-emerald-600 text-white font-bold' : 'text-slate-600' }}">বাং</a>
                        <a href="{{ route('set.locale', 'en') }}" class="px-2 py-1 rounded {{ app()->getLocale() == 'en' ? 'bg-emerald-600 text-white font-bold' : 'text-slate-600' }}">EN</a>
                    </div>

                    @auth
                        @if(in_array(auth()->user()->role, ['super_admin', 'staff', 'dietitian']))
                            <a href="{{ route('admin.dashboard') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-indigo-700 shadow-sm flex items-center gap-2">
                                <i class="fa-solid fa-gauge-high"></i>
                                <span>{{ app()->getLocale() == 'bn' ? 'এডমিন প্যানেল' : 'Admin Panel' }}</span>
                            </a>
                        @else
                            <a href="{{ route('customer.dashboard') }}" class="bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-emerald-700 shadow-sm flex items-center gap-2">
                                <i class="fa-solid fa-calendar-check"></i>
                                <span>{{ app()->getLocale() == 'bn' ? 'আমার ড্যাশবোর্ড' : 'My Dashboard' }}</span>
                            </a>
                        @endif

                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-slate-500 hover:text-rose-600 p-2 text-sm font-medium" title="Logout">
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-700 hover:text-emerald-600 text-sm font-semibold px-3 py-2">
                            {{ app()->getLocale() == 'bn' ? 'লগইন' : 'Login' }}
                        </a>
                        <a href="{{ route('home') }}#packages" class="bg-emerald-600 text-white text-sm font-semibold px-4 py-2.5 rounded-xl hover:bg-emerald-700 shadow-md shadow-emerald-600/20 transition flex items-center gap-2">
                            <i class="fa-solid fa-bolt text-amber-300"></i>
                            <span>{{ app()->getLocale() == 'bn' ? 'সাবস্ক্রাইব করুন' : 'Subscribe Now' }}</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm flex items-center justify-between text-emerald-900">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-xl"></i>
                    <p class="font-medium text-sm sm:text-base">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
            <div class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-xl shadow-sm flex items-center justify-between text-rose-900">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-xl"></i>
                    <p class="font-medium text-sm sm:text-base">{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 border-t border-slate-800 pt-16 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center text-white">
                            <i class="fa-solid fa-apple-whole text-xl"></i>
                        </div>
                        <span class="text-2xl font-black text-white">Nutri<span class="text-emerald-400">Desk</span></span>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        {{ app()->getLocale() == 'bn' 
                            ? 'অফিস কর্মীদের জন্য সময়মতো হাইজিনিক ও পুষ্টিকর ফ্রেশ কাটা ফল ডেস্কে পৌঁছে দেওয়ার অগ্রগামী প্ল্যাটফর্ম।'
                            : 'Delivering fresh, cut, hygienic fruit bowls directly to office desks every single working day.' }}
                    </p>
                    <div class="flex gap-4 text-emerald-400">
                        <a href="#" class="hover:text-emerald-300"><i class="fa-brands fa-facebook text-xl"></i></a>
                        <a href="#" class="hover:text-emerald-300"><i class="fa-brands fa-linkedin text-xl"></i></a>
                        <a href="#" class="hover:text-emerald-300"><i class="fa-brands fa-instagram text-xl"></i></a>
                    </div>
                </div>

                <div>
                    <h4 class="text-white font-bold text-base mb-4">{{ app()->getLocale() == 'bn' ? 'প্যাকেজসমূহ' : 'Our Packages' }}</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}#packages" class="hover:text-emerald-400 transition">{{ app()->getLocale() == 'bn' ? 'শক্তি প্যাকেজ (১ জন)' : 'Shakti Solo Pack (1 Person)' }}</a></li>
                        <li><a href="{{ route('home') }}#packages" class="hover:text-emerald-400 transition">{{ app()->getLocale() == 'bn' ? 'বন্ধু প্যাকেজ (২-৪ জন)' : 'Bondhu Buddy Pack (2-4)' }}</a></li>
                        <li><a href="{{ route('home') }}#packages" class="hover:text-emerald-400 transition">{{ app()->getLocale() == 'bn' ? 'ফুল অফিস টিম প্যাকেজ' : 'Full Office Corporate Pack' }}</a></li>
                        <li><a href="{{ route('home') }}#health" class="hover:text-emerald-400 transition">{{ app()->getLocale() == 'bn' ? 'ডায়াবেটিস ফ্রেন্ডলি ফ্রুট বাউল' : 'Diabetic-Friendly Fruit Bowl' }}</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold text-base mb-4">{{ app()->getLocale() == 'bn' ? 'দ্রুত লিংক' : 'Quick Links' }}</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}#how-it-works" class="hover:text-emerald-400 transition">{{ app()->getLocale() == 'bn' ? 'পজ ও স্কিপ নিয়মাবলী' : 'Pause & Skip Policy' }}</a></li>
                        <li><a href="{{ route('home') }}#menu" class="hover:text-emerald-400 transition">{{ app()->getLocale() == 'bn' ? 'পুষ্টিবিদ অনুমোদন' : 'Nutritionist Curation' }}</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-emerald-400 transition">{{ app()->getLocale() == 'bn' ? 'কাস্টমার লগইন' : 'Customer Login' }}</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-emerald-400 transition">{{ app()->getLocale() == 'bn' ? 'এডমিন পোর্টাল' : 'Admin Portal' }}</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold text-base mb-4">{{ app()->getLocale() == 'bn' ? 'যোগাযোগ' : 'Contact Us' }}</h4>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-location-dot text-emerald-400 mt-1"></i>
                            <span>Kalibari, Chandpur, Bangladesh</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-phone text-emerald-400"></i>
                            <span>+880 1646-696247 / +880 1719860798</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-envelope text-emerald-400"></i>
                            <span>mdrahatkhan2006mr.khan@gmail.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-800 pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500 gap-4">
                <p>&copy; {{ date('Y') }} NutriDesk. {{ app()->getLocale() == 'bn' ? 'সর্বস্বত্ব সংরক্ষিত।' : 'All rights reserved.' }}</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-emerald-400">Privacy Policy</a>
                    <a href="#" class="hover:text-emerald-400">Terms of Service</a>
                    <a href="#" class="hover:text-emerald-400">Refund & Pause Policy</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
