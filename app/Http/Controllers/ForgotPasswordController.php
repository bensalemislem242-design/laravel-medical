<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Mail\ResetPasswordMail;

class ForgotPasswordController extends Controller
{
    public function create()
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Reset link sent to your email!')
            : back()->withErrors(['email' => 'Email not found']);
    }
     public function sendOtp(Request $request)
    {
        // تحقق من الإيميل
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;

        // هنا نعمل OTP عشوائي
        $otp = rand(100000, 999999);

        // ممكن تخزنه في قاعدة البيانات مع صلاحية قصيرة
        // مثال: DB::table('password_resets')->updateOrInsert([...]);

        // ===== هذا هو مكان الكود =====
        Mail::to($email)->send(new ResetPasswordMail($otp, $email));
        // ===== انتهى =====

        return response()->json([
            'success' => true,
            'message' => 'OTP sent to your email',
            'token' => $otp  // ممكن تستخدم token لو تحبي
        ]);
    }
}