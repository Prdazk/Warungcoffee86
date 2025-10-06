<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;

class ReservasiController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah_orang' => 'required|integer|min:1',
            'pilihan_meja' => 'required|string',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'catatan' => 'nullable|string',
        ]);

        // Simpan data ke database
        Reservasi::create([
            'nama' => $request->nama,
            'jumlah_orang' => $request->jumlah_orang,
            'pilihan_meja' => $request->pilihan_meja,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'catatan' => $request->catatan,
        ]);

        // Redirect kembali ke dashboard user dengan pesan sukses
        return redirect()->route('user.dashboard')->with('success', 'Reservasi berhasil dikirim! Kami akan segera memproses pesanan Anda.');
    }
}
