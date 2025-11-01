<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * 🧾 Tampilkan daftar semua admin dengan pagination
     */
    public function index()
    {
        $admins = AdminData::orderByRaw("CASE WHEN jabatan = 'superadmin' THEN 0 ELSE 1 END")
                           ->orderBy('id', 'asc')
                           ->paginate(10);
        return view('admin.dataAdmin.index', compact('admins'));
    }

    /**
     * ➕ Form tambah admin baru (opsional jika pakai modal)
     */
    public function create()
    {
        return view('admin.dataAdmin.create');
    }

    /**
     * 💾 Simpan admin baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:100',
            'email'     => 'required|email|unique:admin_data,email',
            'jabatan'   => 'required|in:admin,superadmin',
            'no_hp'     => 'nullable|string|max:20',
            'password'  => 'required|string|min:6|confirmed',
        ]);

        AdminData::create([
            'nama'      => $request->nama,
            'email'     => $request->email,
            'jabatan'   => $request->jabatan,
            'role'      => $request->jabatan, // role sama dengan jabatan
            'no_hp'     => $request->no_hp,
            'status'    => 0, // default nonaktif, akan aktif saat login
            'password'  => Hash::make($request->password),
        ]);

        return redirect()->route('admin.dataAdmin.index')->with('success', 'Admin berhasil ditambahkan.');
    }

    /**
     * ✏️ Form edit admin
     */
    public function edit(AdminData $admin)
    {
        return view('admin.dataAdmin.edit', compact('admin'));
    }

    /**
     * 🔁 Update data admin
     */
    public function update(Request $request, AdminData $admin)
    {
        $request->validate([
            'nama'    => 'required|string|max:100',
            'email'   => 'required|email|unique:admin_data,email,' . $admin->id,
            'jabatan' => 'required|in:admin,superadmin',
            'no_hp'   => 'nullable|string|max:20',
        ]);

        $admin->update([
            'nama'    => $request->nama,
            'email'   => $request->email,
            'jabatan' => $request->jabatan,
            'role'    => $request->jabatan,
            'no_hp'   => $request->no_hp,
        ]);

        return redirect()->route('admin.dataAdmin.index')->with('success', 'Data admin berhasil diperbarui.');
    }

    /**
     * 🗑️ Hapus admin
     */
    public function destroy(AdminData $admin)
    {
        $admin->delete();
        return redirect()->route('admin.dataAdmin.index')->with('success', 'Data admin berhasil dihapus.');
    }

    /**
     * 🔐 Update password admin
     */
    public function updatePassword(Request $request, AdminData $admin)
    {
        $request->validate([
            'password' => 'required|string|confirmed|min:6',
        ]);

        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.dataAdmin.index')->with('success', 'Password admin berhasil diperbarui.');
    }
}
