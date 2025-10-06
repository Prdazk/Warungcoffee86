<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        return view('admin.login'); // view login admin
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi ketat hanya email & password
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Cek login pakai guard 'admin_user'
        if (Auth::guard('admin_user')->attempt($credentials)) {
            $request->session()->regenerate(); // cegah session fixation
            return redirect()->route('admin.dashboard');
        }

        // Jika gagal, tampilkan error
        return back()->withErrors([
            'email' => 'Email atau password salah!'
        ])->onlyInput('email');
    }

    // Logout admin
    public function logout(Request $request)
    {
        Auth::guard('admin_user')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
