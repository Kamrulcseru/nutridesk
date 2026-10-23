<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fruit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FruitController extends Controller
{
    public function index(Request $request)
    {
        $query = Fruit::query();

        if ($request->filled('origin')) {
            $query->where('origin', $request->origin);
        }

        if ($request->filled('health_tag')) {
            $tag = $request->health_tag;
            if ($tag === 'diabetes') $query->where('safe_for_diabetes', true);
            if ($tag === 'kidney') $query->where('safe_for_kidney', true);
            if ($tag === 'heart') $query->where('safe_for_heart', true);
        }

        $fruits = $query->latest()->paginate(15);

        return view('admin.fruits.index', compact('fruits'));
    }

    public function create()
    {
        return view('admin.fruits.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_bn' => 'required|string|max:255',
            'origin' => 'required|in:local,imported',
            'category' => 'required|string',
            'calories_per_100g' => 'required|numeric|min:0',
            'sugar_g_per_100g' => 'required|numeric|min:0',
            'potassium_mg_per_100g' => 'required|numeric|min:0',
            'fiber_g_per_100g' => 'required|numeric|min:0',
            'season' => 'nullable|string',
            'benefits_en' => 'nullable|string',
            'benefits_bn' => 'nullable|string',
            'image_url' => 'nullable|url',
        ]);

        $validated['slug'] = Str::slug($validated['name_en']);
        $validated['safe_for_diabetes'] = $request->has('safe_for_diabetes');
        $validated['safe_for_kidney'] = $request->has('safe_for_kidney');
        $validated['safe_for_heart'] = $request->has('safe_for_heart');
        $validated['is_active'] = $request->has('is_active');

        Fruit::create($validated);

        return redirect()->route('admin.fruits.index')->with('success', 'Fruit added to inventory successfully!');
    }

    public function edit(Fruit $fruit)
    {
        return view('admin.fruits.edit', compact('fruit'));
    }

    public function update(Request $request, Fruit $fruit)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_bn' => 'required|string|max:255',
            'origin' => 'required|in:local,imported',
            'category' => 'required|string',
            'calories_per_100g' => 'required|numeric|min:0',
            'sugar_g_per_100g' => 'required|numeric|min:0',
            'potassium_mg_per_100g' => 'required|numeric|min:0',
            'fiber_g_per_100g' => 'required|numeric|min:0',
            'season' => 'nullable|string',
            'benefits_en' => 'nullable|string',
            'benefits_bn' => 'nullable|string',
            'image_url' => 'nullable|url',
        ]);

        $validated['safe_for_diabetes'] = $request->has('safe_for_diabetes');
        $validated['safe_for_kidney'] = $request->has('safe_for_kidney');
        $validated['safe_for_heart'] = $request->has('safe_for_heart');
        $validated['is_active'] = $request->has('is_active');

        $fruit->update($validated);

        return redirect()->route('admin.fruits.index')->with('success', 'Fruit details updated successfully!');
    }

    public function destroy(Fruit $fruit)
    {
        $fruit->delete();
        return redirect()->route('admin.fruits.index')->with('success', 'Fruit deleted from catalog!');
    }
}
