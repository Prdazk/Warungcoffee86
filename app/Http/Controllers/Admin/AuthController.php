<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        // pastikan yang sudah login admin tidak bisa buka form login lagi
        $this->middleware('guest:admin')->except('logout');
    }

    // tampilkan halaman login (kamu sudah punya view admin.login)
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            // sukses login: regenerasi session lalu redirect ke dashboard
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        // gagal: kembali ke form dengan pesan error (tidak menyebut mana yang salah)
        return back()
            ->withErrors(['email' => 'Email atau password salah'])
            ->withInput($request->only('email'));
    }

    // logout admin
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
