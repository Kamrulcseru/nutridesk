@extends('layouts.admin')

@section('title', 'Fruit Catalog & Nutrition')
@section('page_title', app()->getLocale() == 'bn' ? 'ফলের ক্যাটালগ ও পুষ্টিমান তালিকা' : 'Fruits Catalog & Nutritional Specs')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4">
        <form method="GET" action="{{ route('admin.fruits.index') }}" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <select name="origin" class="text-xs rounded-xl border-slate-200 focus:border-emerald-500 p-2.5 border" onchange="this.form.submit()">
                <option value="">{{ app()->getLocale() == 'bn' ? 'সকল উৎস' : 'All Origins' }}</option>
                <option value="local" {{ request('origin') === 'local' ? 'selected' : '' }}>দেশি ফল (Local)</option>
                <option value="imported" {{ request('origin') === 'imported' ? 'selected' : '' }}>বিদেশি ফল (Imported)</option>
            </select>

            <select name="health_tag" class="text-xs rounded-xl border-slate-200 focus:border-emerald-500 p-2.5 border" onchange="this.form.submit()">
                <option value="">{{ app()->getLocale() == 'bn' ? 'সকল স্বাস্থ্য ফিল্টার' : 'All Health Conditions' }}</option>
                <option value="diabetes" {{ request('health_tag') === 'diabetes' ? 'selected' : '' }}>ডায়াবেটিসের জন্য নিরাপদ</option>
                <option value="kidney" {{ request('health_tag') === 'kidney' ? 'selected' : '' }}>কিডনি রোগীদের জন্য নিরাপদ</option>
                <option value="heart" {{ request('health_tag') === 'heart' ? 'selected' : '' }}>হার্ট রোগীদের জন্য নিরাপদ</option>
            </select>
        </form>

        <a href="{{ route('admin.fruits.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-plus"></i>
            <span>{{ app()->getLocale() == 'bn' ? 'নতুন ফল যোগ করুন' : 'Add New Fruit' }}</span>
        </a>
    </div>

    <!-- Fruits Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-900 uppercase tracking-wider font-bold border-b border-slate-100">
                    <tr>
                        <th class="p-4">Fruit</th>
                        <th class="p-4">Origin</th>
                        <th class="p-4">Calories (100g)</th>
                        <th class="p-4">Sugar / Fiber</th>
                        <th class="p-4">Potassium</th>
                        <th class="p-4">Safety Tags</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($fruits as $fruit)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0">
                                        <img src="{{ $fruit->image_url ?? 'https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?w=100' }}" alt="{{ $fruit->name_en }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-900 block text-sm">{{ $fruit->name_bn }}</span>
                                        <span class="text-slate-400 text-[11px]">{{ $fruit->name_en }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $fruit->origin === 'local' ? 'bg-emerald-100 text-emerald-800' : 'bg-purple-100 text-purple-800' }}">
                                    {{ $fruit->origin }}
                                </span>
                            </td>
                            <td class="p-4 font-bold text-slate-800">{{ $fruit->calories_per_100g }} kcal</td>
                            <td class="p-4 text-slate-600">
                                <span>Sugar: {{ $fruit->sugar_g_per_100g }}g</span><br>
                                <span class="text-slate-400">Fiber: {{ $fruit->fiber_g_per_100g }}g</span>
                            </td>
                            <td class="p-4 font-medium text-slate-800">{{ $fruit->potassium_mg_per_100g }} mg</td>
                            <td class="p-4">
                                <div class="flex flex-wrap gap-1">
                                    @if($fruit->safe_for_diabetes)
                                        <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-amber-100 text-amber-800">Diabetes Safe</span>
                                    @endif
                                    @if($fruit->safe_for_kidney)
                                        <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-sky-100 text-sky-800">Kidney Safe</span>
                                    @endif
                                    @if($fruit->safe_for_heart)
                                        <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-rose-100 text-rose-800">Heart Safe</span>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4">
                                @if($fruit->is_active)
                                    <span class="text-emerald-600 font-bold text-xs"><i class="fa-solid fa-circle text-[8px] mr-1"></i> Active</span>
                                @else
                                    <span class="text-slate-400 text-xs font-bold">Inactive</span>
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.fruits.edit', $fruit->id) }}" class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700" title="Edit Fruit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.fruits.destroy', $fruit->id) }}" method="POST" onsubmit="return confirm('Delete this fruit?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-slate-400">No fruits found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $fruits->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
