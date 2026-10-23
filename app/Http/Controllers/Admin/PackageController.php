<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::orderBy('sort_order', 'asc')->get();
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_bn' => 'required|string|max:255',
            'code' => 'required|string|unique:packages,code',
            'min_persons' => 'required|integer|min:1',
            'max_persons' => 'required|integer|min:1',
            'grams_per_person_daily' => 'required|integer|min:50',
            'price_7_days' => 'required|numeric|min:0',
            'price_30_days' => 'required|numeric|min:0',
            'price_per_person_per_day' => 'required|numeric|min:0',
            'description_en' => 'nullable|string',
            'description_bn' => 'nullable|string',
            'badge_text' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['slug'] = Str::slug($validated['name_en']);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        // Parse features lines into array
        if ($request->filled('features_en_text')) {
            $validated['features_en'] = array_filter(array_map('trim', explode("\n", $request->features_en_text)));
        }
        if ($request->filled('features_bn_text')) {
            $validated['features_bn'] = array_filter(array_map('trim', explode("\n", $request->features_bn_text)));
        }

        Package::create($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Package created successfully!');
    }

    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_bn' => 'required|string|max:255',
            'code' => 'required|string|unique:packages,code,' . $package->id,
            'min_persons' => 'required|integer|min:1',
            'max_persons' => 'required|integer|min:1',
            'grams_per_person_daily' => 'required|integer|min:50',
            'price_7_days' => 'required|numeric|min:0',
            'price_30_days' => 'required|numeric|min:0',
            'price_per_person_per_day' => 'required|numeric|min:0',
            'description_en' => 'nullable|string',
            'description_bn' => 'nullable|string',
            'badge_text' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        if ($request->filled('features_en_text')) {
            $validated['features_en'] = array_filter(array_map('trim', explode("\n", $request->features_en_text)));
        }
        if ($request->filled('features_bn_text')) {
            $validated['features_bn'] = array_filter(array_map('trim', explode("\n", $request->features_bn_text)));
        }

        $package->update($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully!');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('admin.packages.index')->with('success', 'Package deleted successfully!');
    }
}
