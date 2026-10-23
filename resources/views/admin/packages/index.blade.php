@extends('layouts.admin')

@section('title', 'Package Management')
@section('page_title', app()->getLocale() == 'bn' ? 'প্যাকেজ ম্যানেজমেন্ট (শক্তি, বন্ধু, অফিস)' : 'Packages Management')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h3 class="font-bold text-slate-900 text-lg">
                {{ app()->getLocale() == 'bn' ? 'সাবস্ক্রিপশন প্যাকেজ তালিকা' : 'All Subscription Packages' }}
            </h3>
            <p class="text-xs text-slate-500">Configure Shakti Solo, Bondhu Buddy, and Full Office Corporate packages</p>
        </div>
        <a href="{{ route('admin.packages.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-plus"></i>
            <span>{{ app()->getLocale() == 'bn' ? 'নতুন প্যাকেজ যোগ করুন' : 'Create New Package' }}</span>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($packages as $pkg)
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start mb-4">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800">
                            CODE: {{ $pkg->code }}
                        </span>
                        @if($pkg->is_active)
                            <span class="text-emerald-600 text-xs font-bold"><i class="fa-solid fa-circle text-[8px] mr-1"></i> Active</span>
                        @else
                            <span class="text-slate-400 text-xs font-bold">Inactive</span>
                        @endif
                    </div>

                    <h4 class="text-xl font-black text-slate-900 mb-1">{{ $pkg->name_bn }}</h4>
                    <span class="text-xs text-slate-400 block mb-4">{{ $pkg->name_en }}</span>

                    <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-100 mb-4 space-y-1.5 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slate-500">১ মাস মূল্য:</span>
                            <span class="font-bold text-slate-900">৳{{ number_format($pkg->price_30_days, 0) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">৭ দিন ট্রায়াল:</span>
                            <span class="font-bold text-slate-900">৳{{ number_format($pkg->price_7_days, 0) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">দৈনিক পরিমাণ:</span>
                            <span class="font-bold text-emerald-700">{{ $pkg->grams_per_person_daily }}g / জন</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">অনুমোদিত লোকসংখ্যা:</span>
                            <span class="font-bold text-slate-700">{{ $pkg->min_persons }} - {{ $pkg->max_persons }} জন</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-between items-center">
                    <span class="text-xs text-slate-400">Sort: #{{ $pkg->sort_order }}</span>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.packages.edit', $pkg->id) }}" class="p-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold flex items-center gap-1">
                            <i class="fa-solid fa-pen"></i> Edit
                        </a>
                        <form action="{{ route('admin.packages.destroy', $pkg->id) }}" method="POST" onsubmit="return confirm('Delete this package?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-bold">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
