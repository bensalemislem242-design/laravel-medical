<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{


    public function login(Request $request)
    {
        //    handel GET /login
        if ($request->isMethod('get')) {
            return view('auth.login');
        }

        //    handel POST /login
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        // نضيف Remember Me
        $remember = $request->filled('remember');
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate(); // حماية CSRF
            return redirect()->route('dashboard');
        }

        // if the user doesn't exist in the DB

        return redirect()
            ->route('login')
            ->withErrors('Provided login information is not valid.');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'You are logged out.');
    }
}
