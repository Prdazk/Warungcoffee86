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
    /**
     * Tampilkan form login admin.
     */
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.beranda');
        }
        return view('admin.login');
    }

    /**
     * Proses login admin.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Ambil admin berdasarkan email
        $admin = AdminData::where('email', $request->email)->first();

        // Jika email/password salah
        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
        }

        // Login menggunakan guard admin
        Auth::guard('admin')->login($admin, $request->boolean('remember'));
        $request->session()->regenerate();

        // Set status admin ini aktif (1)
        AdminData::where('id', $admin->id)->update(['status' => 1]);

        // Cek apakah harus ganti password pertama kali (opsional)
        if ($admin->must_change_password ?? false) {
            return redirect()->route('admin.change-password.form')
                ->with('success', 'Silakan ganti password pertama kali!');
        }

        return redirect()->route('admin.beranda')
            ->with('success', 'Selamat datang, ' . $admin->nama);
    }

    /**
     * Logout admin.
     */
    public function logout(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        // Set status admin ini nonaktif (0)
        if ($admin) {
            AdminData::where('id', $admin->id)->update(['status' => 0]);
        }

        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login.form')
            ->with('success', 'Anda telah logout.');
    }

    /**
     * Halaman beranda admin.
     * Bisa menampilkan jumlah reservasi baru untuk notifikasi.
     */
    public function beranda()
    {
        $jumlahBaru = Reservasi::where('status', 'baru')->count();

        return view('admin.beranda', [
            'jumlahBaru' => $jumlahBaru,
            'adminNama'  => Auth::guard('admin')->check() ? Auth::guard('admin')->user()->nama : null,
        ]);
    }
}
