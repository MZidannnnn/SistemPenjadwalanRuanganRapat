<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse; // Jangan lupa import ini


class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Menangani proses autentikasi.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // 2. Coba lakukan login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 3. Jika berhasil, redirect ke dashboard
            return redirect()->intended('dashboard');
        }

        // 4. Jika gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'username' => 'Username atau password yang diberikan salah.',
        ])->onlyInput('username');
    }
    /**
     * Menangani proses logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        // 1. Lakukan logout user
        Auth::logout();

        // 2. Invalidate sesi user agar tidak bisa digunakan lagi
        $request->session()->invalidate();

        // 3. Buat ulang token CSRF untuk keamanan
        $request->session()->regenerateToken();

        // 4. Redirect ke halaman login
        return redirect('/login');
    }
}
