<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // ======================================================================
    // DATA ADMIN CRUD
    // ======================================================================

    // Tampilkan daftar admin
    public function index()
    {
        $admins = AdminData::all();
        return view('admin.dataAdmin.index', compact('admins'));
    }

    // Form tambah admin
    public function create()
    {
        return view('admin.dataAdmin.create');
    }

    // Simpan admin baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:admins_data,email',
            'jabatan' => 'required|string',
            'role' => 'required|in:admin,superadmin',
        ]);

        // Simpan admin baru dengan password default
        AdminData::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'role' => $request->role,
            'password' => Hash::make('123456'), // password default
        ]);

        return redirect()->route('admin.dataAdmin.index')
                         ->with('success', 'Admin berhasil ditambahkan. Password default: 123456');
    }

    // Form edit admin
    public function edit(AdminData $admin)
    {
        return view('admin.dataAdmin.edit', compact('admin'));
    }

    // Update admin
    public function update(Request $request, AdminData $admin)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:admins_data,email,'.$admin->id,
            'jabatan' => 'required|string',
            'role' => 'required|in:admin,superadmin',
        ]);

        $admin->update($request->only(['nama','email','jabatan','role']));

        return redirect()->route('admin.dataAdmin.index')
                         ->with('success', 'Admin berhasil diupdate');
    }

    // Hapus admin
    public function destroy(AdminData $admin)
    {
        $admin->delete();

        return redirect()->route('admin.dataAdmin.index')
                         ->with('success', 'Admin berhasil dihapus');
    }

    // ======================================================================
    // KELOLA PASSWORD
    // ======================================================================

    // Form kelola password
    public function editPassword(AdminData $admin)
    {
        return view('admin.dataAdmin.password', compact('admin'));
    }

    // Update password
    public function updatePassword(Request $request, AdminData $admin)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed', // harus ada password_confirmation
        ]);

        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect()->route('admin.dataAdmin.index')
                         ->with('success', 'Password admin berhasil diperbarui!');
    }
}
