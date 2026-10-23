<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DietitianMenu;
use App\Models\Fruit;
use App\Models\Package;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function packages()
    {
        $packages = Package::active()->get();

        return response()->json([
            'success' => true,
            'count' => $packages->count(),
            'data' => $packages,
        ]);
    }

    public function packageDetail($code)
    {
        $package = Package::where('code', $code)->orWhere('slug', $code)->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $package,
        ]);
    }

    public function fruits(Request $request)
    {
        $query = Fruit::active();

        if ($request->has('safe_for')) {
            $condition = $request->query('safe_for');
            if ($condition === 'diabetes') {
                $query->where('safe_for_diabetes', true);
            } elseif ($condition === 'kidney') {
                $query->where('safe_for_kidney', true);
            } elseif ($condition === 'heart') {
                $query->where('safe_for_heart', true);
            }
        }

        if ($request->has('origin')) {
            $query->where('origin', $request->query('origin'));
        }

        $fruits = $query->get();

        return response()->json([
            'success' => true,
            'count' => $fruits->count(),
            'data' => $fruits,
        ]);
    }

    public function dietitianWeeklyMenu(Request $request)
    {
        $condition = $request->query('condition', 'general');

        $menus = DietitianMenu::where('health_condition', $condition)
            ->where('is_active', true)
            ->get();

        return response()->json([
            'success' => true,
            'condition' => $condition,
            'data' => $menus,
        ]);
    }
}
