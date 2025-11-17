<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminData;
use App\Models\Reservasi;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.beranda');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $admin = AdminData::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
        }

        Auth::guard('admin')->login($admin, $request->boolean('remember'));
        $request->session()->regenerate();

        AdminData::where('id', $admin->id)->update(['status' => 1]);

        if ($admin->must_change_password ?? false) {
            return redirect()->route('admin.change-password.form')
                ->with('success', 'Silakan ganti password pertama kali!');
        }

        return redirect()->route('admin.beranda')
            ->with('success', 'Selamat datang, ' . $admin->nama);
    }

    public function logout(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        if ($admin) {
            AdminData::where('id', $admin->id)->update(['status' => 0]);
        }

        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login.form')
            ->with('success', 'Anda telah logout.');
    }

    public function beranda()
    {
        $jumlahBaru = Reservasi::where('status', 'baru')->count();

        return view('admin.beranda', [
            'jumlahBaru' => $jumlahBaru,
            'adminNama'  => Auth::guard('admin')->check() ? Auth::guard('admin')->user()->nama : null,
        ]);
    }
}