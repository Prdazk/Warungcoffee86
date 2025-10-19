<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    // Tampilkan semua menu
    public function index()
    {
        $menus = Menu::all();
        return view('admin.menu.index', compact('menus'));
    }

    // Tampilkan form tambah menu
    public function create()
    {
        return view('admin.menu.create'); // Buat file create.blade.php nanti
    }

    // Simpan menu baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'kategori' => 'required|string',
            'status' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $gambarName = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarName = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('images'), $gambarName);
        }

        Menu::create([
            'name' => $request->nama,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
            'status' => $request->status,
            'gambar' => $gambarName,
        ]);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    // Tampilkan form edit menu
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.menu.edit', compact('menu')); // Buat file edit.blade.php nanti
    }

    // Update menu
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'kategori' => 'required|string',
            'status' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($menu->gambar && file_exists(public_path('images/' . $menu->gambar))) {
                unlink(public_path('images/' . $menu->gambar));
            }
            $gambar = $request->file('gambar');
            $menu->gambar = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('images'), $menu->gambar);
        }

        $menu->update([
            'name' => $request->nama,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
            'status' => $request->status,
            // 'gambar' sudah diupdate di atas jika ada
        ]);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diperbarui!');
    }

    // Hapus menu
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        if ($menu->gambar && file_exists(public_path('images/' . $menu->gambar))) {
            unlink(public_path('images/' . $menu->gambar));
        }
        $menu->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus!');
    }
}
