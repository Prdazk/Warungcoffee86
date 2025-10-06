<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * 🧾 Tampilkan semua menu di beranda admin
     */
    public function index()
    {
        // Ambil semua data menu untuk ditampilkan di tabel
        $menus = Menu::orderBy('created_at', 'desc')->get();
        return view('admin.beranda', compact('menus'));
    }

    /**
     * ➕ Simpan menu baru (dari modal tambah)
     */
    public function store(Request $request)
    {
        // Validasi input form
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Upload gambar jika ada
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
        }

        // Simpan ke database
        Menu::create([
            'name' => $validated['name'],
            'harga' => $validated['price'],
            'kategori' => $validated['category'],
            'status' => $validated['status'],
            'gambar' => $imageName,
        ]);

        // Setelah berhasil tambah, redirect kembali ke halaman beranda (menu)
        return redirect()->route('admin.beranda', ['section' => 'menu'])
                         ->with('success', '✅ Menu baru berhasil ditambahkan!');
    }

    /**
     * 🗑️ Hapus menu
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        // Hapus file gambar jika ada
        if ($menu->gambar && file_exists(public_path('images/' . $menu->gambar))) {
            unlink(public_path('images/' . $menu->gambar));
        }

        $menu->delete();

        return redirect()->route('admin.beranda', ['section' => 'menu'])
                         ->with('success', '🗑️ Menu berhasil dihapus.');
    }

    /**
     * ✏️ Update menu (form edit)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $menu = Menu::findOrFail($id);

        $menu->name = $request->name;
        $menu->harga = $request->price;
        $menu->kategori = $request->category;
        $menu->status = $request->status;

        // Ganti gambar jika upload baru
        if ($request->hasFile('image')) {
            if ($menu->gambar && file_exists(public_path('images/' . $menu->gambar))) {
                unlink(public_path('images/' . $menu->gambar));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $menu->gambar = $imageName;
        }

        $menu->save();

        return redirect()->route('admin.beranda', ['section' => 'menu'])
                         ->with('success', '✏️ Menu berhasil diperbarui.');
    }
}
