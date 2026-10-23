@extends('layouts.admin')

@section('title', 'Edit Fruit: ' . $fruit->name_bn)
@section('page_title', 'Edit Fruit Metadata & Safety')

@section('content')
<div class="max-w-3xl bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-6">
    <div class="flex justify-between items-center border-b border-slate-100 pb-4">
        <div>
            <h3 class="text-xl font-bold text-slate-900">Edit Fruit: {{ $fruit->name_bn }}</h3>
            <p class="text-xs text-slate-500">Update calories, sugar, potassium, fiber and medical safety</p>
        </div>
        <a href="{{ route('admin.fruits.index') }}" class="text-xs text-emerald-700 font-bold hover:underline">
            &larr; Back to Fruits
        </a>
    </div>

    <form action="{{ route('admin.fruits.update', $fruit->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Fruit Name (English) *</label>
                <input type="text" name="name_en" value="{{ old('name_en', $fruit->name_en) }}" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Fruit Name (Bangla) *</label>
                <input type="text" name="name_bn" value="{{ old('name_bn', $fruit->name_bn) }}" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Origin *</label>
                <select name="origin" class="w-full text-xs rounded-xl border-slate-200 p-2.5 border font-semibold">
                    <option value="local" {{ $fruit->origin === 'local' ? 'selected' : '' }}>দেশি ফল (Local)</option>
                    <option value="imported" {{ $fruit->origin === 'imported' ? 'selected' : '' }}>বিদেশি ফল (Imported)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Category</label>
                <input type="text" name="category" value="{{ old('category', $fruit->category) }}" class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Calories (100g) *</label>
                <input type="number" step="0.01" name="calories_per_100g" value="{{ old('calories_per_100g', $fruit->calories_per_100g) }}" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Sugar (g/100g) *</label>
                <input type="number" step="0.01" name="sugar_g_per_100g" value="{{ old('sugar_g_per_100g', $fruit->sugar_g_per_100g) }}" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Potassium (mg) *</label>
                <input type="number" step="0.01" name="potassium_mg_per_100g" value="{{ old('potassium_mg_per_100g', $fruit->potassium_mg_per_100g) }}" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Fiber (g/100g) *</label>
                <input type="number" step="0.01" name="fiber_g_per_100g" value="{{ old('fiber_g_per_100g', $fruit->fiber_g_per_100g) }}" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>
        </div>

        <!-- Health Safety Toggles -->
        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-2">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider text-[11px]">মেডিকেল সেফটি ট্যাগ (Medical Safety)</label>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                    <input type="checkbox" name="safe_for_diabetes" value="1" {{ $fruit->safe_for_diabetes ? 'checked' : '' }} class="rounded text-emerald-600">
                    <span>ডায়াবেটিসের জন্য নিরাপদ</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                    <input type="checkbox" name="safe_for_kidney" value="1" {{ $fruit->safe_for_kidney ? 'checked' : '' }} class="rounded text-emerald-600">
                    <span>কিডনি রোগীর জন্য নিরাপদ</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                    <input type="checkbox" name="safe_for_heart" value="1" {{ $fruit->safe_for_heart ? 'checked' : '' }} class="rounded text-emerald-600">
                    <span>হার্ট রোগীর জন্য নিরাপদ</span>
                </label>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Image URL</label>
            <input type="url" name="image_url" value="{{ old('image_url', $fruit->image_url) }}" class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Health Benefits (English)</label>
                <textarea name="benefits_en" rows="2" class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">{{ old('benefits_en', $fruit->benefits_en) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Health Benefits (Bangla)</label>
                <textarea name="benefits_bn" rows="2" class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">{{ old('benefits_bn', $fruit->benefits_bn) }}</textarea>
            </div>
        </div>

        <div>
            <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                <input type="checkbox" name="is_active" value="1" {{ $fruit->is_active ? 'checked' : '' }} class="rounded text-emerald-600"> Active Fruit
            </label>
        </div>

        <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
            <a href="{{ route('admin.fruits.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50">Cancel</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md">Update Fruit</button>
        </div>
    </form>
</div>
@endsection
