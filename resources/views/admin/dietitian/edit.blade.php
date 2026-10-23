@extends('layouts.admin')

@section('title', 'Edit Menu: ' . ucfirst($dietitianMenu->day_of_week))
@section('page_title', 'Update Dietitian Menu Plan')

@section('content')
<div class="max-w-3xl bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-6">
    <div class="flex justify-between items-center border-b border-slate-100 pb-4">
        <div>
            <h3 class="text-xl font-bold text-slate-900">
                Edit {{ ucfirst($dietitianMenu->day_of_week) }} Plan ({{ strtoupper($dietitianMenu->health_condition) }})
            </h3>
            <p class="text-xs text-slate-500">Tune fruit ingredients, calories, carbs, fiber and clinical advice</p>
        </div>
        <a href="{{ route('admin.dietitian.index', ['condition' => $dietitianMenu->health_condition]) }}" class="text-xs text-emerald-700 font-bold hover:underline">
            &larr; Back to Schedule
        </a>
    </div>

    <form action="{{ route('admin.dietitian.update', $dietitianMenu->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Title (English) *</label>
                <input type="text" name="title_en" value="{{ old('title_en', $dietitianMenu->title_en) }}" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Title (Bangla) *</label>
                <input type="text" name="title_bn" value="{{ old('title_bn', $dietitianMenu->title_bn) }}" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Total Calories (kcal) *</label>
                <input type="number" name="calories_total" value="{{ old('calories_total', $dietitianMenu->calories_total) }}" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Carbs (g) *</label>
                <input type="number" step="0.01" name="carbs_g" value="{{ old('carbs_g', $dietitianMenu->carbs_g) }}" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Fiber (g) *</label>
                <input type="number" step="0.01" name="fiber_g" value="{{ old('fiber_g', $dietitianMenu->fiber_g) }}" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Vitamins & Micronutrients Focus</label>
            <input type="text" name="vitamins_focus" value="{{ old('vitamins_focus', $dietitianMenu->vitamins_focus) }}" placeholder="e.g. Vitamin C, Quercetin, Papain" class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Clinical Advice (English)</label>
                <textarea name="dietitian_advice_en" rows="3" class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">{{ old('dietitian_advice_en', $dietitianMenu->dietitian_advice_en) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Clinical Advice (Bangla)</label>
                <textarea name="dietitian_advice_bn" rows="3" class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">{{ old('dietitian_advice_bn', $dietitianMenu->dietitian_advice_bn) }}</textarea>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
            <a href="{{ route('admin.dietitian.index', ['condition' => $dietitianMenu->health_condition]) }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50">Cancel</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md">Update Menu Plan</button>
        </div>
    </form>
</div>
@endsection
