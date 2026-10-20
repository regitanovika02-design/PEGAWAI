<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    // Validasi input hanya memastikan form terisi
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // BYPASS: Ambil user pertama yang ada di database (atau buat paksa masuk)
    $user = \App\Models\User::first();

    if ($user) {
        // Langsung login-kan sebagai user pertama tanpa cek password asli
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->intended('/departments');
    }

    return back()->withErrors([
        'email' => 'Belum ada data user sama sekali di database. Jalankan seeder dulu!',
    ]);
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}