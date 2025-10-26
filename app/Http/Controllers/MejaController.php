<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class MejaController extends Controller
{
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

    public function store(Request $request)
    {
        $request->validate([
            'nama_meja' => 'required|string|max:100|unique:mejas,nama_meja',
        ]);

        // Tambah meja baru
        Meja::create([
            'nama_meja' => ucfirst($request->nama_meja),
            'kapasitas' => 4, // Default kapasitas
            'status_meja' => 'Kosong',
        ]);

        return back()->with('success', 'Meja baru berhasil ditambahkan!');
    }
}
