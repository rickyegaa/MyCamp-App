<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials['status_aktif'] = true;

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('penyewa.index'));
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi salah, atau akun sedang nonaktif.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}