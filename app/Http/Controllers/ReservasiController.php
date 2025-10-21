<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;

class ReservasiController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah_orang' => 'required|integer|min:1',
            'pilihan_meja' => 'required|string',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'catatan' => 'nullable|string',
        ]);

        // Simpan data ke database, tambahkan status 'baru' untuk notifikasi
        $reservasi = Reservasi::create(array_merge($validated, [
            'status' => 'baru',
        ]));

        // Redirect ke dashboard user dengan flash message sukses
        return redirect()->route('user.dashboard')
                         ->with('success', 'Reservasi berhasil dikirim! Kami akan segera memproses pesanan Anda.');
    }
}
