<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Enums\UserRoles;
use Illuminate\Support\Facades\Hash;

class DoctorApiController extends Controller
{
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $doctor = User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'specialty' => $request->specialty,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $request->image,
            'role' => UserRoles::DOCTOR // important
        ]);

        return response()->json([
            'message' => 'Doctor registered successfully',
            'doctor' => $doctor
        ], 201);
    }
    // ======== Login Doctor =========
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        // تحقق من اليوزر
        $doctor = User::where('email', $request->email)
                      ->where('role', UserRoles::DOCTOR)
                      ->first();

        if (!$doctor || !Hash::check($request->password, $doctor->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        // إنشاء token جديد
        $token = $doctor->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Doctor logged in successfully',
            'doctor' => $doctor,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 200);
    }

}
