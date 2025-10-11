<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    // ======================================================
    // 🟢 1. TAMPILKAN FORM LOGIN
    // ======================================================
    public function showLoginForm()
    {
        // Jika sudah login, langsung ke dashboard
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.beranda');
        }

        // Cek pesan error dari session
        $error = session('error');
        $success = session('success');

        return view('admin.login', compact('error', 'success'));
    }

    // ======================================================
    // 🟡 2. PROSES LOGIN ADMIN
    // ======================================================
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Coba login pakai guard admin
        if (Auth::guard('admin')->attempt([
            'email'    => $request->email,
            'password' => $request->password
        ])) {
            // Regenerasi session untuk keamanan
            $request->session()->regenerate();

            // Redirect ke halaman admin beranda
            return redirect()->route('admin.beranda');
        }

        // Jika gagal login, tetap di halaman login
        return back()->with('error', 'Email atau password salah!');
    }

    // ======================================================
    // 🔴 3. LOGOUT ADMIN
    // ======================================================
    public function logout(Request $request)
    {
        // Logout guard admin
        Auth::guard('admin')->logout();

        // Bersihkan session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman login admin
        return redirect()->route('admin.login.form')
                         ->with('success', 'Anda telah logout.');
    }
}
