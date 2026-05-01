<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;

class PasswordResetController extends Controller
{
    // ================= SEND OTP =================
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        // فقط الـ Patient
        $user = User::where('email', $request->email)
                    ->where('role', \App\Enums\UserRoles::PATIENT)
                    ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $otp = rand(100000, 999999);
        $token = Str::random(60);

        // تخزين OTP + token في جدول password_resets
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => $token,
                'otp' => $otp,
                'created_at' => Carbon::now()
            ]
        );

        // إرسال OTP على البريد
        Mail::to($user->email)->send(new ResetPasswordMail($otp, $user->email));

        // DEBUG في اللوج
        \Log::info("OTP for {$user->email}: $otp");

        return response()->json([
            'success' => true,
            'message' => 'OTP sent to your email',
            'token' => $token  // يجب الاحتفاظ به في Flutter
        ]);
    }

    // ================= VERIFY OTP =================
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
            'token' => 'required'
        ]);

        $reset = DB::table('password_resets')
                    ->where('email', $request->email)
                    ->where('otp', $request->otp)
                    ->where('token', $request->token)
                    ->first();

        if (!$reset) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP or token'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'OTP verified successfully'
        ]);
    }

    // ================= RESET PASSWORD =================
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        $reset = DB::table('password_resets')
                    ->where('email', $request->email)
                    ->where('token', $request->token)
                    ->first();

        if (!$reset) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token'
            ], 400);
        }

        $user = User::where('email', $request->email)
                    ->where('role', \App\Enums\UserRoles::PATIENT)
                    ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        // تحديث كلمة السر
        $user->password = bcrypt($request->password);
        $user->save();

        // حذف سجل الـ OTP بعد إعادة تعيين كلمة السر
        DB::table('password_resets')->where('email', $request->email)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully'
        ]);
    }

    // ================= RESEND OTP =================
    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        // استدعاء sendOtp
        return $this->sendOtp($request);
    }
}
