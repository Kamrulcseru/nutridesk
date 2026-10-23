@extends('layouts.admin')

@section('title', 'Dietitian Rotation Scheduler')
@section('page_title', app()->getLocale() == 'bn' ? 'পুষ্টিবিদ সাপ্তাহিক মেনু শিডিউলার' : 'Dietitian Weekly Menu Scheduler')

@section('content')
<div class="space-y-6">
    <!-- Condition Selector Tabs -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4">
        <div>
            <h3 class="font-bold text-slate-900 text-base">
                {{ app()->getLocale() == 'bn' ? 'সাপ্তাহিক কর্মদিবসের ফলের রোটেশন মেনু' : 'Workday Daily Fruit Rotation Plans' }}
            </h3>
            <p class="text-xs text-slate-500">Curate daily fruit combination, calories and clinical advice for each health condition</p>
        </div>

        <div class="flex items-center gap-2 bg-slate-100 p-1 rounded-xl text-xs font-bold">
            <a href="{{ route('admin.dietitian.index', ['condition' => 'general']) }}" class="px-3 py-1.5 rounded-lg transition {{ $condition === 'general' ? 'bg-white text-emerald-700 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                General Fitness
            </a>
            <a href="{{ route('admin.dietitian.index', ['condition' => 'diabetes']) }}" class="px-3 py-1.5 rounded-lg transition {{ $condition === 'diabetes' ? 'bg-white text-amber-700 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                Diabetes Care
            </a>
            <a href="{{ route('admin.dietitian.index', ['condition' => 'kidney']) }}" class="px-3 py-1.5 rounded-lg transition {{ $condition === 'kidney' ? 'bg-white text-sky-700 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                Kidney Care
            </a>
            <a href="{{ route('admin.dietitian.index', ['condition' => 'heart']) }}" class="px-3 py-1.5 rounded-lg transition {{ $condition === 'heart' ? 'bg-white text-rose-700 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                Heart Care
            </a>
        </div>
    </div>

    <!-- Menus by Day Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($menus as $menu)
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-emerald-100 text-emerald-800">
                            {{ $menu->day_of_week }}
                        </span>
                        <span class="text-xs font-bold text-slate-400">{{ $menu->calories_total }} kcal</span>
                    </div>

                    <h4 class="font-bold text-slate-900 text-base mb-1">{{ $menu->title_bn }}</h4>
                    <span class="text-xs text-slate-400 block mb-4">{{ $menu->title_en }}</span>

                    <!-- Fruits in Bowl -->
                    <div class="space-y-1.5 mb-4 text-xs">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">বাউলে যা যা ফল থাকছে:</span>
                        @if(is_array($menu->fruits_list))
                            @foreach($menu->fruits_list as $f)
                                <div class="flex justify-between bg-slate-50 px-2.5 py-1.5 rounded-xl border border-slate-100 text-slate-700">
                                    <span>{{ $f['fruit_bn'] ?? $f['fruit'] }}</span>
                                    <span class="font-bold text-slate-500">{{ $f['grams'] }}g</span>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- Clinical notes -->
                    <div class="bg-emerald-50/60 p-3 rounded-2xl border border-emerald-100 text-xs text-emerald-800 space-y-1">
                        <span class="font-bold block text-[11px] text-emerald-900">পুষ্টিবিদের মন্তব্য / Clinical Focus:</span>
                        <p class="text-[11px] leading-relaxed">{{ $menu->dietitian_advice_bn }}</p>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end mt-4">
                    <a href="{{ route('admin.dietitian.edit', $menu->id) }}" class="px-3.5 py-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition flex items-center gap-1.5">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>Edit Day's Menu</span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
