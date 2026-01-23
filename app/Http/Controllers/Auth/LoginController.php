<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // 1. Nampilin halaman login.blade lo
    public function index()
    {
        return view('auth.login');
    }

    // 2. Proses ngecek email & password
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Kalau sukses, lempar ke dashboard
            return redirect()->intended('dashboard');
        }

        // Kalau gagal, balikin lagi ke login dengan pesan error
        return back()->withErrors([
            'email' => 'Waduh Bos, email atau passwordnya nggak cocok nih.',
        ])->onlyInput('email');
    }

    // 3. Buat keluar/logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}