<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // ===============================================================
    // 📋 CRUD DATA ADMIN
    // ===============================================================

    /**
     * Tampilkan daftar admin
     */
    public function index()
    {
        $admins = AdminData::orderBy('id', 'asc')->paginate(5);
        return view('admin.dataAdmin.index', compact('admins'));
    }

    /**
     * Form tambah admin
     */
    public function create()
    {
        return view('admin.dataAdmin.create');
    }

    /**
     * Simpan admin baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:admin_data,email',
            'jabatan' => 'required|string|max:100',
            'no_hp' => 'required|string|max:20',
            'role' => 'required|in:admin,superadmin',
            'password' => 'required|string|confirmed|min:6',
        ]);

        AdminData::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'no_hp' => $request->no_hp,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.dataAdmin.index')
                         ->with('success', 'Admin berhasil ditambahkan!');
    }

    /**
     * Form edit admin
     */
    public function edit(AdminData $admin)
    {
        return view('admin.dataAdmin.edit', compact('admin'));
    }

    /**
     * Update data admin
     */
    public function update(Request $request, AdminData $admin)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:admin_data,email,' . $admin->id,
            'jabatan' => 'required|string|max:100',
            'no_hp' => 'required|string|max:20',
            'role' => 'required|in:admin,superadmin',
        ]);

        $admin->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'no_hp' => $request->no_hp,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.dataAdmin.index')
                         ->with('success', 'Data admin berhasil diperbarui!');
    }

    /**
     * Hapus admin
     */
    public function destroy(AdminData $admin)
    {
        $admin->delete();

        return redirect()->route('admin.dataAdmin.index')
                         ->with('success', 'Admin berhasil dihapus!');
    }

    // ===============================================================
    // 🔒 KELOLA PASSWORD
    // ===============================================================

    /**
     * Form edit password
     */
    public function editPassword(AdminData $admin)
    {
        return view('admin.dataAdmin.password', compact('admin'));
    }

    /**
     * Update password admin
     */
    public function updatePassword(Request $request, AdminData $admin)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama salah',
            ])->withInput();
        }

        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.dataAdmin.index')
                         ->with('success', 'Password admin berhasil diperbarui!');
    }
}
