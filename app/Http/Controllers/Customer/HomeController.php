<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\DietitianMenu;
use App\Models\Fruit;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        $packages = Package::active()->get();
        $fruits = Fruit::active()->get();
        $dietitianMenus = DietitianMenu::where('health_condition', 'general')->where('is_active', true)->get();
        $diabeticMenus = DietitianMenu::where('health_condition', 'diabetes')->where('is_active', true)->get();

        return view('customer.home', compact('packages', 'fruits', 'dietitianMenus', 'diabeticMenus'));
    }

    public function setLocale($locale)
    {
        if (in_array($locale, ['bn', 'en'])) {
            Session::put('locale', $locale);
            if (auth()->check()) {
                auth()->user()->update(['preferred_language' => $locale]);
            }
        }

        return redirect()->back();
    }
}
