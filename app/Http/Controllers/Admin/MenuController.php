<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $perPage = 5;
        $menus = Menu::latest()->paginate($perPage);
        return view('admin.menu.index', compact('menus'));
    }

    // Tambah Menu
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'     => 'required|string|max:255',
            'harga'    => 'required|numeric|min:0',
            'kategori' => 'required|string|max:100',
            'status'   => 'required|string|max:50',
            'gambar'   => 'nullable|mimes:jpeg,png,jpg,gif,webp|max:8192',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            if (!is_dir(public_path('images'))) {
                mkdir(public_path('images'), 0755, true);
            }

            $file->move(public_path('images'), $filename);
            $validated['gambar'] = $filename;
        }

        $menu = Menu::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil ditambahkan',
            'menu'    => $menu
        ]);
    }

    // Edit Menu (ambil data)
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return response()->json($menu);
    }

    // Update Menu
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

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil diperbarui',
            'menu'    => $menu
        ]);
    }


    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        if ($menu->gambar && file_exists(public_path('images/' . $menu->gambar))) {
            @unlink(public_path('images/' . $menu->gambar));
        }
        $menu->delete();

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu berhasil dihapus');
    }


    // API untuk semua menu
    public function apiMenus()
    {
        $menus = Menu::all();
        return response()->json($menus);
    }
}
