<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WebAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors(['email' => 'Your account is deactivated. Please contact support.']);
            }

            // Redirect based on role
            if (in_array($user->role, ['super_admin', 'staff', 'dietitian'])) {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('customer.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string',
            'office_name' => 'nullable|string',
            'office_address' => 'nullable|string',
            'office_floor' => 'nullable|string',
            'desk_number' => 'nullable|string',
            'health_condition' => 'required|in:general,diabetes,kidney,heart',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
            'phone' => $validated['phone'],
            'office_name' => $validated['office_name'] ?? null,
            'office_address' => $validated['office_address'] ?? null,
            'office_floor' => $validated['office_floor'] ?? null,
            'desk_number' => $validated['desk_number'] ?? null,
            'health_condition' => $validated['health_condition'] ?? 'general',
            'preferred_language' => session('locale', 'bn'),
            'is_active' => true,
        ]);

        Auth::login($user);

        return redirect()->route('customer.dashboard')->with('success', 'Welcome to NutriDesk! Your account is ready.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Logged out successfully');
    }
}
