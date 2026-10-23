<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'required|string',
            'office_name' => 'nullable|string',
            'office_address' => 'nullable|string',
            'office_floor' => 'nullable|string',
            'desk_number' => 'nullable|string',
            'health_condition' => 'nullable|in:general,diabetes,kidney,heart',
            'allergies_notes' => 'nullable|string',
            'preferred_language' => 'nullable|in:bn,en',
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
            'allergies_notes' => $validated['allergies_notes'] ?? null,
            'preferred_language' => $validated['preferred_language'] ?? 'bn',
            'is_active' => true,
        ]);

        $token = $user->createToken('nutridesk_mobile_app')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registration successful! Welcome to NutriDesk.',
            'message_bn' => 'নিবন্ধন সফল হয়েছে! নিউট্রিডেস্কে আপনাকে স্বাগতম।',
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials do not match our records.'],
            ]);
        }

        if (!$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Your account is deactivated. Please contact support.',
                'message_bn' => 'আপনার একাউন্টটি নিষ্ক্রিয় করা আছে। দয়া করে সাপোর্টে যোগাযোগ করুন।',
            ], 403);
        }

        $token = $user->createToken('nutridesk_auth')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'message_bn' => 'সফলভাবে লগইন হয়েছে',
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->user()->load(['subscriptions' => function ($q) {
            $q->latest()->with('package');
        }]);

        return response()->json([
            'success' => true,
            'user' => $user,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string',
            'office_name' => 'nullable|string',
            'office_address' => 'nullable|string',
            'office_floor' => 'nullable|string',
            'desk_number' => 'nullable|string',
            'health_condition' => 'nullable|in:general,diabetes,kidney,heart',
            'allergies_notes' => 'nullable|string',
            'preferred_delivery_time' => 'nullable|string',
            'preferred_language' => 'nullable|in:bn,en',
        ]);

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'message_bn' => 'প্রোফাইল সফলভাবে আপডেট করা হয়েছে',
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully',
            'message_bn' => 'সফলভাবে লগআউট সম্পন্ন হয়েছে',
        ]);
    }
}
