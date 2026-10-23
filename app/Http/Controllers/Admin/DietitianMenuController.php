<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DietitianMenu;
use App\Models\Fruit;
use Illuminate\Http\Request;

class DietitianMenuController extends Controller
{
    public function index(Request $request)
    {
        $condition = $request->query('condition', 'general');
        $menus = DietitianMenu::where('health_condition', $condition)->get();
        $fruits = Fruit::active()->get();

        return view('admin.dietitian.index', compact('menus', 'condition', 'fruits'));
    }

    public function edit(DietitianMenu $dietitianMenu)
    {
        $fruits = Fruit::active()->get();
        return view('admin.dietitian.edit', compact('dietitianMenu', 'fruits'));
    }

    public function update(Request $request, DietitianMenu $dietitianMenu)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_bn' => 'required|string|max:255',
            'calories_total' => 'required|integer|min:0',
            'carbs_g' => 'required|numeric|min:0',
            'fiber_g' => 'required|numeric|min:0',
            'vitamins_focus' => 'nullable|string',
            'dietitian_advice_en' => 'nullable|string',
            'dietitian_advice_bn' => 'nullable|string',
        ]);

        if ($request->has('fruits_list_json')) {
            $decoded = json_decode($request->fruits_list_json, true);
            if (is_array($decoded)) {
                $validated['fruits_list'] = $decoded;
            }
        }

        $dietitianMenu->update($validated);

        return redirect()->route('admin.dietitian.index', ['condition' => $dietitianMenu->health_condition])
            ->with('success', 'Dietitian rotation menu updated successfully!');
    }
}
