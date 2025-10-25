<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\Meja;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    // ===== Tampilkan daftar reservasi + data meja =====
    public function index()
    {
        $reservasis = Reservasi::latest()->get();
        $mejas = Meja::orderBy('id', 'asc')->get();
        return view('admin.reservasi.index', compact('reservasis', 'mejas'));
    }

    // ===== Ambil data reservasi terbaru (AJAX polling) =====
    public function latest()
    {
        $reservasis = Reservasi::latest()->get();
        // kembalikan JSON untuk dipakai JS
        return response()->json($reservasis);
    }

    // ===== Tambah meja =====
    public function storeMeja(Request $request)
    {
        $request->validate([
            'nama_meja' => 'required|string|max:100|unique:mejas,nama_meja',
        ]);

        Meja::create([
            'nama_meja' => $request->nama_meja,
            'status_meja' => 'Tersedia',
        ]);

        return back()->with('success', 'Meja baru berhasil ditambahkan!');
    }

    // ===== Hapus meja =====
    public function destroyMeja($id)
    {
        $meja = Meja::findOrFail($id);

        if (Reservasi::where('pilihan_meja', $meja->nama_meja)->exists()) {
            return back()->with('error', 'Meja sedang digunakan, tidak bisa dihapus.');
        }

        $meja->delete();
        return back()->with('success', 'Meja berhasil dihapus!');
    }

    // ===== Hapus reservasi =====
    public function destroy($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        // Kembalikan status meja jika ada
        if ($reservasi->pilihan_meja) {
            $meja = Meja::where('nama_meja', $reservasi->pilihan_meja)->first();
            if ($meja) {
                $meja->status_meja = 'Tersedia';
                $meja->save();
            }
        }

        $reservasi->delete();

        return redirect()->route('admin.reservasi.index')
            ->with('success', 'Reservasi berhasil dihapus!');
    }

    // ===== Edit / Update reservasi =====
    public function update(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah_orang' => 'required|integer|min:1',
            'pilihan_meja' => 'nullable|string|max:50',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'catatan' => 'nullable|string|max:500',
        ]);

        // Jika meja diganti, update status meja lama dan baru
        if ($request->pilihan_meja && $request->pilihan_meja != $reservasi->pilihan_meja) {
            // Kembalikan meja lama ke tersedia
            if ($reservasi->pilihan_meja) {
                $mejaLama = Meja::where('nama_meja', $reservasi->pilihan_meja)->first();
                if ($mejaLama) {
                    $mejaLama->status_meja = 'Tersedia';
                    $mejaLama->save();
                }
            }

            // Set meja baru jadi terpakai
            $mejaBaru = Meja::where('nama_meja', $request->pilihan_meja)->first();
            if ($mejaBaru) {
                $mejaBaru->status_meja = 'Terpakai';
                $mejaBaru->save();
            }
        }

        // Update data reservasi
        $reservasi->update([
            'nama' => $request->nama,
            'jumlah_orang' => $request->jumlah_orang,
            'pilihan_meja' => $request->pilihan_meja,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('admin.reservasi.index')
            ->with('success', 'Reservasi berhasil diperbarui!');
    }
}
