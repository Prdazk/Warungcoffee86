<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    /** 🟩 Tampilkan semua menu (dengan pagination terbaru) */
    public function index()
    {
        $perPage = 5;
        $menus = Menu::latest()->paginate($perPage);
        return view('admin.menu.index', compact('menus'));
    }

    /** 🟨 Simpan menu baru */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'     => 'required|string|max:255',
            'harga'    => 'required|numeric|min:0',
            'kategori' => 'required|string|max:100',
            'status'   => 'required|string|max:50',
            'gambar'   => 'nullable|mimes:jpeg,png,jpg,gif,webp|max:8192',
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            if (!is_dir(public_path('images'))) {
                mkdir(public_path('images'), 0755, true);
            }

            $file->move(public_path('images'), $filename);
            $validated['gambar'] = $filename;
        }

        // Simpan ke DB
        Menu::create($validated);

        // Redirect ke halaman terakhir agar menu baru langsung terlihat
        $perPage = 5;
        $lastPage = ceil(Menu::count() / $perPage);

        return redirect()
            ->route('admin.menu.index', ['page' => $lastPage])
            ->with('success', 'Menu berhasil ditambahkan');
    }

    /** 🟧 Tampilkan form edit menu */
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.menu.edit', compact('menu'));
    }

    /** 🟥 Update menu */
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $validated = $request->validate([
            'nama'     => 'required|string|max:255',
            'harga'    => 'required|numeric|min:0',
            'kategori' => 'required|string|max:100',
            'status'   => 'required|string|max:50',
            'gambar'   => 'nullable|mimes:jpeg,png,jpg,gif,webp|max:8192',
        ]);

        // Jika upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($menu->gambar && file_exists(public_path('images/' . $menu->gambar))) {
                @unlink(public_path('images/' . $menu->gambar));
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('images'), $filename);
            $validated['gambar'] = $filename;
        } else {
            // Simpan gambar lama
            $validated['gambar'] = $menu->gambar;
        }

        $menu->update($validated);

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Menu berhasil diperbarui');
    }

    /** ⛔ Hapus menu */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        if ($menu->gambar && file_exists(public_path('images/' . $menu->gambar))) {
            @unlink(public_path('images/' . $menu->gambar));
        }

        $menu->delete();

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Menu berhasil dihapus');
    }

    /** 🔵 API untuk realtime menu di User/Menu */
    public function apiMenus()
    {
        return response()->json(
            Menu::select('id','nama','harga','kategori','status','gambar')
                ->latest()
                ->get()
        );
    }
}
