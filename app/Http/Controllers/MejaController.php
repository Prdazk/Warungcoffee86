<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    /**
     * Tampilkan halaman tambah meja dan status meja
     */
    public function index()
    {
        // Ambil semua meja
        $mejas = Meja::orderBy('id', 'asc')->get();

        // Ambil reservasi aktif
        $reservasis = Reservasi::whereIn('status', ['Dipesan', 'Terisi'])->get();

        // Sinkronkan status meja berdasarkan reservasi
        foreach ($mejas as $meja) {
            $reservasi = $reservasis->firstWhere('meja_id', $meja->id);

            if ($reservasi) {
                $meja->status_meja = $reservasi->status;
                $meja->nama_pemesan = $reservasi->nama ?? '-';
            } else {
                $meja->status_meja = 'Kosong';
                $meja->nama_pemesan = '-';
            }
        }

        return view('admin.reservasi.tambah-meja', compact('mejas'));
    }

    /**
     * Simpan meja baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_meja' => 'required|string|max:100|unique:mejas,nama_meja',
        ]);

        Meja::create([
            'nama_meja' => ucfirst($request->nama_meja),
            'status_meja' => 'Kosong', // default status
        ]);

        return back()->with('success', 'Meja baru berhasil ditambahkan!');
    }

    /**
     * Hapus meja
     */
    public function destroy(Meja $meja)
    {
        $meja->delete();
        return back()->with('success', 'Meja berhasil dihapus!');
    }
}
