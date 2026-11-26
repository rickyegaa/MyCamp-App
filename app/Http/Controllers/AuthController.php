<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            $pesan = 'Email atau password salah.';

            return back()
                ->withInput($request->only('email'))
                ->with('error', $pesan)
                ->withErrors(['email' => $pesan]);
        }

        $user = Auth::user();
        $roleAkun = strtolower($user->role->nama_role ?? '');
        $tabDipilih = strtolower($request->input('login_role', ''));

        if ($tabDipilih !== '' && $roleAkun !== $tabDipilih) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $pesan = 'Akun ini terdaftar sebagai ' . ucfirst($roleAkun) . '. Silakan login melalui tab Login ' . ucfirst($roleAkun) . '.';

            return back()
                ->withInput($request->only('email'))
                ->with('error', $pesan)
                ->withErrors(['email' => $pesan]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('penyewa.index'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}