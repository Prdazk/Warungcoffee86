<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminData;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Tampilkan daftar admin (superadmin only)
     */
    public function index()
    {
        $admins = AdminData::all();
        return view('admin.dataAdmin.index', compact('admins'));
    }

    /**
     * Form tambah admin baru
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
            'nama' => 'required|string',
            'email' => 'required|email|unique:admins_data,email',
            'jabatan' => 'required|string',
        ]);

        AdminData::create($request->all());

        return redirect()->route('admin.dataAdmin.index')
                         ->with('success', 'Admin berhasil ditambahkan');
    }

    /**
     * Form edit admin
     */
    public function edit(AdminData $admin)
    {
        return view('admin.dataAdmin.edit', compact('admin'));
    }

    /**
     * Update admin
     */
    public function update(Request $request, AdminData $admin)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:admins_data,email,'.$admin->id,
            'jabatan' => 'required|string',
        ]);

        $admin->update($request->all());

        return redirect()->route('admin.dataAdmin.index')
                         ->with('success', 'Admin berhasil diupdate');
    }

    /**
     * Hapus admin
     */
    public function destroy(AdminData $admin)
    {
        $admin->delete();

        return redirect()->route('admin.dataAdmin.index')
                         ->with('success', 'Admin berhasil dihapus');
    }
}
