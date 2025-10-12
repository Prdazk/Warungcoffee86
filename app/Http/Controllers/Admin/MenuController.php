<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Reservasi;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        $reservasis = Reservasi::all();

        return view('admin.beranda', compact('menus', 'reservasis'));
    }

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

        return redirect()->route('admin.beranda')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        if ($menu->gambar && file_exists(public_path('images/' . $menu->gambar))) {
            unlink(public_path('images/' . $menu->gambar));
        }
        $menu->delete();

        return redirect()->route('admin.beranda')->with('success', 'Menu berhasil dihapus!');
    }
}
