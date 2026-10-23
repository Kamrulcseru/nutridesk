@extends('layouts.admin')

@section('title', 'Edit Package: ' . $package->name_bn)
@section('page_title', 'Edit Subscription Package')

@section('content')
<div class="max-w-3xl bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-6">
    <div class="flex justify-between items-center border-b border-slate-100 pb-4">
        <div>
            <h3 class="text-xl font-bold text-slate-900">Edit Package: {{ $package->name_bn }}</h3>
            <p class="text-xs text-slate-500">Update pricing, description, grams portion, and features</p>
        </div>
        <a href="{{ route('admin.packages.index') }}" class="text-xs text-emerald-700 font-bold hover:underline">
            &larr; Back to Packages
        </a>
    </div>

    <form action="{{ route('admin.packages.update', $package->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Package Name (English) *</label>
                <input type="text" name="name_en" value="{{ old('name_en', $package->name_en) }}" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Package Name (Bangla) *</label>
                <input type="text" name="name_bn" value="{{ old('name_bn', $package->name_bn) }}" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Unique Code *</label>
                <input type="text" name="code" value="{{ old('code', $package->code) }}" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border font-mono">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Min Persons</label>
                <input type="number" name="min_persons" value="{{ old('min_persons', $package->min_persons) }}" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Max Persons</label>
                <input type="number" name="max_persons" value="{{ old('max_persons', $package->max_persons) }}" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Daily Grams/Person *</label>
                <input type="number" name="grams_per_person_daily" value="{{ old('grams_per_person_daily', $package->grams_per_person_daily) }}" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">7 Days Price (৳) *</label>
                <input type="number" step="0.01" name="price_7_days" value="{{ old('price_7_days', $package->price_7_days) }}" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">30 Days Price (৳) *</label>
                <input type="number" step="0.01" name="price_30_days" value="{{ old('price_30_days', $package->price_30_days) }}" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Price/Day/Person (৳)</label>
                <input type="number" step="0.01" name="price_per_person_per_day" value="{{ old('price_per_person_per_day', $package->price_per_person_per_day) }}" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Description (English)</label>
                <textarea name="description_en" rows="2" class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">{{ old('description_en', $package->description_en) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Description (Bangla)</label>
                <textarea name="description_bn" rows="2" class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">{{ old('description_bn', $package->description_bn) }}</textarea>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Bullet Points (English - 1 per line)</label>
                <textarea name="features_en_text" rows="3" class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">{{ old('features_en_text', is_array($package->features_en) ? implode("\n", $package->features_en) : '') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Bullet Points (Bangla - 1 per line)</label>
                <textarea name="features_bn_text" rows="3" class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">{{ old('features_bn_text', is_array($package->features_bn) ? implode("\n", $package->features_bn) : '') }}</textarea>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Badge Text (Optional)</label>
                <input type="text" name="badge_text" value="{{ old('badge_text', $package->badge_text) }}" class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $package->sort_order) }}" class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>

            <div class="flex items-center gap-6 mt-4">
                <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                    <input type="checkbox" name="is_featured" value="1" {{ $package->is_featured ? 'checked' : '' }} class="rounded text-emerald-600"> Featured
                </label>
                <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                    <input type="checkbox" name="is_active" value="1" {{ $package->is_active ? 'checked' : '' }} class="rounded text-emerald-600"> Active
                </label>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
            <a href="{{ route('admin.packages.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50">Cancel</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md">Update Package</button>
        </div>
    </form>
</div>
@endsection
