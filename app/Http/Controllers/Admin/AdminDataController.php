<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * 🧾 Tampilkan daftar semua admin dengan pagination
     */
    public function index()
    {
        $admins = AdminData::orderBy('id', 'asc')->paginate(10);
        return view('admin.dataAdmin.index', compact('admins'));
    }

    /**
     * ➕ Form tambah admin baru
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
            'email'     => 'required|email|unique:admins_data,email',
            'jabatan'   => 'required|string|max:100',
            'no_hp'     => 'nullable|string|max:20',
            'role'      => 'required|string|max:50',
            'password'  => 'required|string|min:6|confirmed',
        ]);

        AdminData::create([
            'nama'      => $request->nama,
            'email'     => $request->email,
            'jabatan'   => $request->jabatan,
            'no_hp'     => $request->no_hp,
            'role'      => $request->role,
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
            'nama'      => 'required|string|max:100',
            'email'     => 'required|email|unique:admins_data,email,' . $admin->id,
            'jabatan'   => 'required|string|max:100',
            'no_hp'     => 'nullable|string|max:20',
            'role'      => 'required|string|max:50',
        ]);

        $admin->update([
            'nama'    => $request->nama,
            'email'   => $request->email,
            'jabatan' => $request->jabatan,
            'no_hp'   => $request->no_hp,
            'role'    => $request->role,
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
     * 🔐 Form edit password (opsional, bisa digunakan jika ingin modal khusus)
     */
    public function editPassword(AdminData $admin)
    {
        return view('admin.dataAdmin.password', compact('admin'));
    }

    /**
     * 🔐 Update password admin
     * ✅ Mengecek password lama sebelum update
     */
    public function updatePassword(Request $request, AdminData $admin)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password'         => 'required|string|confirmed|min:6',
        ]);

        // Cek password lama
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah!'])->withInput();
        }

        // Update password baru
        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.dataAdmin.index')->with('success', 'Password admin berhasil diperbarui.');
    }
}
