<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    // Halaman daftar admin
    public function index()
    {
        $admins = User::whereIn('role', ['admin', 'superadmin'])->get();
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,superadmin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.dataAdmin.index')->with('success', 'Admin baru berhasil ditambahkan!');
    }

    // Form edit admin
    public function edit($id)
    {
        $admin = User::findOrFail($id);
        return view('admin.dataAdmin.edit', compact('admin'));
    }

    // Update admin
    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$admin->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:admin,superadmin',
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;
        if ($request->password) {
            $admin->password = bcrypt($request->password);
        }
        $admin->role = $request->role;
        $admin->save();

        return redirect()->route('admin.dataAdmin.index')->with('success', 'Admin berhasil diperbarui!');
    }

    // Hapus admin
    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.dataAdmin.index')->with('success', 'Admin berhasil dihapus!');
    }
}
