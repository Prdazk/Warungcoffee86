<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // ======================================================================
    // 📋 DATA ADMIN CRUD
    // ======================================================================

    public function index()
    {
        $admins = AdminData::orderBy('id', 'asc')->paginate(5);
        return view('admin.dataAdmin.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.dataAdmin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:admin_data,email',
            'jabatan' => 'required|string|max:100',
            'role' => 'required|in:admin,superadmin',
            'password' => 'required|string|confirmed|min:6',
        ]);

        AdminData::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.dataAdmin.index')
                         ->with('success', 'Admin berhasil ditambahkan!');
    }

    public function edit(AdminData $admin)
    {
        return view('admin.dataAdmin.edit', compact('admin'));
    }

    public function update(Request $request, AdminData $admin)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:admin_data,email,' . $admin->id,
            'jabatan' => 'required|string|max:100',
            'role' => 'required|in:admin,superadmin',
        ]);

        $admin->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.dataAdmin.index')
                         ->with('success', 'Data admin berhasil diperbarui!');
    }

    public function destroy(AdminData $admin)
    {
        $admin->delete();

        return redirect()->route('admin.dataAdmin.index')
                         ->with('success', 'Admin berhasil dihapus!');
    }

    // ======================================================================
    // 🔒 KELOLA PASSWORD
    // ======================================================================

    public function editPassword(AdminData $admin)
    {
        return view('admin.dataAdmin.password', compact('admin'));
    }

    public function updatePassword(Request $request, AdminData $admin)
    {
        // Validasi input
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|confirmed|min:6', // password_confirmation otomatis diperiksa
        ]);

        // Cek password lama
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama Anda salah'
            ])->withInput();
        }

        // Update password baru
        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect()->route('admin.dataAdmin.index')
                         ->with('success', 'Password admin berhasil diperbarui!');
    }
}
