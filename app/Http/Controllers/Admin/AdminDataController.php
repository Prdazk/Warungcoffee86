<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * 🧾 Tampilkan daftar semua admin
     */
    public function index()
    {
        // Gunakan pagination agar tidak berat
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
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:admins_data,email',
            'jabatan' => 'required|string|max:100',
            'role' => 'required|string|max:50',
            'password' => 'required|string|min:6|confirmed',
        ]);

        AdminData::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        // SweetAlert sudah handle di front-end, jadi tidak perlu alert tambahan
        return redirect()->route('admin.dataAdmin.index');
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
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:admins_data,email,' . $admin->id,
            'jabatan' => 'required|string|max:100',
            'role' => 'required|string|max:50',
        ]);

        $admin->update($request->only(['nama', 'email', 'jabatan', 'role']));

        return redirect()->route('admin.dataAdmin.index');
    }

    /**
     * 🗑️ Hapus admin
     */
    public function destroy(AdminData $admin)
    {
        $admin->delete();

        return redirect()->route('admin.dataAdmin.index');
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

        return redirect()->route('admin.dataAdmin.index');
    }
}
