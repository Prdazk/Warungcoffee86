<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * 🧾 Tampilkan semua menu & reservasi di beranda admin
     */
    public function index()
    {
        // Ambil semua data menu dan reservasi
        $menus = Menu::orderBy('created_at', 'desc')->get();
        $reservasis = Reservasi::orderBy('created_at', 'desc')->get();

        // Kirim data ke beranda admin
        return view('admin.beranda', compact('menus', 'reservasis'));
    }

    /**
     * ➕ Simpan menu baru (dari modal tambah)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
        }

        Menu::create([
            'name' => $validated['name'],
            'harga' => $validated['price'],
            'kategori' => $validated['category'],
            'status' => $validated['status'],
            'gambar' => $imageName,
        ]);

        return redirect()->route('admin.beranda', ['section' => 'menu'])
                         ->with('success', '✅ Menu baru berhasil ditambahkan!');
    }

    /**
     * ✏️ Update menu
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

        // Jika ada upload gambar baru
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

    /**
     * 🗑️ Hapus menu
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        if ($menu->gambar && file_exists(public_path('images/' . $menu->gambar))) {
            unlink(public_path('images/' . $menu->gambar));
        }

        $menu->delete();

        return redirect()->route('admin.beranda', ['section' => 'menu'])
                         ->with('success', '🗑️ Menu berhasil dihapus.');
    }
}
