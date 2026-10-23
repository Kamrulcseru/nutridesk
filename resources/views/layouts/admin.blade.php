<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriDesk Admin - @yield('title', 'Operations Dashboard')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', 'Hind Siliguri', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-slate-200 flex flex-col flex-shrink-0 z-20 border-r border-slate-800 hidden md:flex">
        <!-- Logo -->
        <div class="h-20 flex items-center px-6 border-b border-slate-800/80 gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-500 to-amber-400 flex items-center justify-center text-white shadow-md">
                <i class="fa-solid fa-apple-whole text-xl"></i>
            </div>
            <div>
                <span class="text-xl font-black text-white tracking-tight">Nutri<span class="text-emerald-400">Desk</span></span>
                <span class="block text-[10px] text-emerald-400 uppercase tracking-widest font-bold">Admin Console</span>
            </div>
        </div>

        <!-- User Role Badge -->
        <div class="p-4 mx-4 my-4 rounded-xl bg-slate-800/80 border border-slate-700/60 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-emerald-600/30 text-emerald-400 flex items-center justify-center font-bold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="overflow-hidden">
                <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                <div class="flex items-center gap-1.5 mt-0.5">
                    @if(auth()->user()->role === 'super_admin')
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">SUPER ADMIN</span>
                    @elseif(auth()->user()->role === 'staff')
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-500/20 text-blue-300 border border-blue-500/30">STAFF / OPERATIONS</span>
                    @elseif(auth()->user()->role === 'dietitian')
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-purple-500/20 text-purple-300 border border-purple-500/30">DIETITIAN</span>
                    @else
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-500/20 text-slate-300">USER</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Navigation Menu -->
        <nav class="flex-1 px-4 space-y-1.5 overflow-y-auto">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                <i class="fa-solid fa-chart-pie w-5 text-center text-emerald-400"></i>
                <span>{{ app()->getLocale() == 'bn' ? 'ড্যাশবোর্ড ও রিপোর্ট' : 'Dashboard' }}</span>
            </a>

            <!-- Orders & Deliveries (Super Admin & Staff) -->
            <div class="pt-2">
                <span class="px-3 text-[11px] font-bold uppercase tracking-wider text-slate-400">অপারেশন / Operations</span>
            </div>

            <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.orders.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                <i class="fa-solid fa-cart-shopping w-5 text-center text-blue-400"></i>
                <span>{{ app()->getLocale() == 'bn' ? 'অর্ডার প্রসেসিং' : 'Orders Processing' }}</span>
            </a>

            <a href="{{ route('admin.kitchen.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.kitchen.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                <i class="fa-solid fa-utensils w-5 text-center text-amber-400"></i>
                <span>{{ app()->getLocale() == 'bn' ? 'কিচেন ও ডেলিভারি বোর্ড' : 'Kitchen & Dispatch' }}</span>
            </a>

            <a href="{{ route('admin.sms.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.sms.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                <i class="fa-solid fa-comment-sms w-5 text-center text-teal-400"></i>
                <span>{{ app()->getLocale() == 'bn' ? 'এসএমএস নোটিফিকেশন' : 'SMS Logs' }}</span>
            </a>

            <!-- Nutrition & Catalog (Super Admin & Dietitian) -->
            @if(in_array(auth()->user()->role, ['super_admin', 'dietitian']))
                <div class="pt-2">
                    <span class="px-3 text-[11px] font-bold uppercase tracking-wider text-slate-400">পুষ্টি ও ক্যাটালগ / Nutrition</span>
                </div>

                <a href="{{ route('admin.dietitian.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.dietitian.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                    <i class="fa-solid fa-clipboard-check w-5 text-center text-emerald-400"></i>
                    <span>{{ app()->getLocale() == 'bn' ? 'পুষ্টিবিদ শিডিউলার' : 'Dietitian Schedule' }}</span>
                </a>

                <a href="{{ route('admin.fruits.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.fruits.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                    <i class="fa-solid fa-lemon w-5 text-center text-yellow-400"></i>
                    <span>{{ app()->getLocale() == 'bn' ? 'ফলের ইনভেন্টরি' : 'Fruit Inventory' }}</span>
                </a>
            @endif

            <!-- Super Admin Exclusive (Packages & Users) -->
            @if(auth()->user()->role === 'super_admin')
                <div class="pt-2">
                    <span class="px-3 text-[11px] font-bold uppercase tracking-wider text-amber-400/80">সুপার এডমিন কন্ট্রোল</span>
                </div>

                <a href="{{ route('admin.packages.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.packages.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                    <i class="fa-solid fa-box-open w-5 text-center text-indigo-400"></i>
                    <span>{{ app()->getLocale() == 'bn' ? 'প্যাকেজ ম্যানেজমেন্ট' : 'Packages (শক্তি/বন্ধু)' }}</span>
                </a>

                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.users.*') ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-800' }}">
                    <i class="fa-solid fa-users-gear w-5 text-center text-rose-400"></i>
                    <span>{{ app()->getLocale() == 'bn' ? 'ইউজার ও রোল পারমিশন' : 'Users & Permissions' }}</span>
                </a>
            @endif
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-slate-800 space-y-2">
            <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-2 px-3 rounded-lg bg-slate-800 hover:bg-slate-700 text-xs text-slate-300 transition">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>{{ app()->getLocale() == 'bn' ? 'কাস্টমার ওয়েবসাইট দেখুন' : 'Visit Customer Site' }}</span>
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center justify-center gap-2 w-full py-2 px-3 rounded-lg text-rose-400 hover:bg-rose-500/10 text-xs font-semibold transition">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>{{ app()->getLocale() == 'bn' ? 'লগআউট' : 'Logout' }}</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <!-- Topbar -->
        <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-6 z-10">
            <div class="flex items-center gap-4">
                <!-- Mobile toggle button -->
                <button class="md:hidden text-slate-600 hover:text-slate-900" onclick="alert('Menu')">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <div>
                    <h1 class="text-xl font-bold text-slate-900">@yield('page_title', 'Dashboard')</h1>
                    <p class="text-xs text-slate-500">
                        {{ date('l, d M Y') }} &bull; {{ app()->getLocale() == 'bn' ? 'অফিস ডেলিভারি স্লট: সকাল ১০:০০ - ১১:৩০' : 'Office Slot: 10:00 AM - 11:30 AM' }}
                    </p>
                </div>
            </div>

            <!-- Topbar Actions -->
            <div class="flex items-center gap-4">
                <!-- Language Switcher -->
                <div class="flex items-center bg-slate-100 rounded-lg p-1 text-xs font-semibold">
                    <a href="{{ route('set.locale', 'bn') }}" class="px-2.5 py-1 rounded {{ app()->getLocale() == 'bn' ? 'bg-white shadow text-emerald-700 font-bold' : 'text-slate-600' }}">বাংলা</a>
                    <a href="{{ route('set.locale', 'en') }}" class="px-2.5 py-1 rounded {{ app()->getLocale() == 'en' ? 'bg-white shadow text-emerald-700 font-bold' : 'text-slate-600' }}">English</a>
                </div>

                <!-- User profile link -->
                <div class="flex items-center gap-2 pl-3 border-l border-slate-200">
                    <div class="w-9 h-9 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="hidden sm:block text-left text-xs">
                        <span class="font-bold text-slate-800 block">{{ auth()->user()->name }}</span>
                        <span class="text-slate-500">{{ auth()->user()->email }}</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Alerts -->
        @if(session('success'))
            <div class="mx-6 mt-4 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between text-sm">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        @if(session('error'))
            <div class="mx-6 mt-4 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between text-sm">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation text-rose-500"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        <!-- Scrollable Page Content -->
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>

</body>
</html>
