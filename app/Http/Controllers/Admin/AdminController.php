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
        $admins = AdminData::where('role', 'admin')->get();
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
        ]);

        AdminData::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'role' => $request->role,
            'password' => Hash::make('123456'),
        ]);

        return redirect()->route('admin.dataAdmin.index')
                         ->with('success', 'Admin berhasil ditambahkan! (Password default: 123456)');
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

        $admin->update($request->only(['nama', 'email', 'jabatan', 'role']));

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
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect()->route('admin.dataAdmin.index')
                         ->with('success', 'Password admin berhasil diperbarui!');
    }
}
