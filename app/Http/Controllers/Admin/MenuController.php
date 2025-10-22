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
        $menus = Menu::latest()->paginate(5); // pagination aktif
        return view('admin.menu.index', compact('menus'));
    }

    /** 🟦 Tampilkan form tambah menu (opsional jika modal di index) */
    public function create()
    {
        return view('admin.menu.create');
    }

    /** 🟨 Simpan menu baru */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'     => 'required|string|max:255',
            'harga'    => 'required|numeric|min:0',
            'kategori' => 'required|string|max:100',
            'status'   => 'required|string|max:50',
            'gambar'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Proses upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Pastikan folder images ada dan writable
            if (!is_dir(public_path('images'))) {
                mkdir(public_path('images'), 0755, true);
            }

            $file->move(public_path('images'), $filename);
            $validated['gambar'] = $filename;
        }

        // Simpan ke database
        Menu::create($validated);

        return redirect()
            ->route('admin.menu.index')
            ->with('success', '✅ Menu berhasil ditambahkan');
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
            'gambar'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload gambar baru jika ada
        if ($request->hasFile('gambar')) {
            if ($menu->gambar && file_exists(public_path('images/' . $menu->gambar))) {
                @unlink(public_path('images/' . $menu->gambar));
            }
            $file = $request->file('gambar');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $validated['gambar'] = $filename;
        } else {
            $validated['gambar'] = $menu->gambar;
        }

        $menu->update($validated);

        return redirect()
            ->route('admin.menu.index')
            ->with('success', '✅ Menu berhasil diperbarui');
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
            ->with('success', '🗑️ Menu berhasil dihapus');
    }
}
