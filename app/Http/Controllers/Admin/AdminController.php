<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $admins = AdminData::orderByRaw("CASE WHEN role = 'superadmin' THEN 0 ELSE 1 END")
                           ->orderBy('id', 'asc')
                           ->paginate(5);

        return view('admin.dataAdmin.index', compact('admins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:admin_data,email',
            'jabatan' => 'required|in:admin,superadmin', 
            'no_hp' => 'nullable|string|max:20',
            'password' => 'required|string|confirmed|min:6',
        ]);

        $role = $request->jabatan;

        $loggedAdmin = Auth::guard('admin')->user();
        $status = ($loggedAdmin && $loggedAdmin->role === 'superadmin') ? 1 : 0;

        AdminData::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'role' => $role,
            'no_hp' => $request->no_hp,
            'status' => 0,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.dataAdmin.index')
                         ->with('success', 'Admin berhasil ditambahkan!');
    }

    public function update(Request $request, AdminData $admin)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:admin_data,email,' . $admin->id,
            'jabatan' => 'required|in:admin,superadmin',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $role = $request->jabatan;

        $admin->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'role' => $role,
            'no_hp' => $request->no_hp,
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

    public function updatePassword(Request $request, AdminData $admin)
    {
        $request->validate([
            'password' => 'required|string|confirmed|min:6',
        ]);

        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.dataAdmin.index')
                         ->with('success', 'Password admin berhasil diperbarui!');
    }
}