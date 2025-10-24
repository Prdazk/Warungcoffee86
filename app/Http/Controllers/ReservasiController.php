<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;

class ReservasiController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah_orang' => 'required|integer|min:1|max:10',
            'pilihan_meja' => 'required|string',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'catatan' => 'nullable|string',
        ]);

        Reservasi::create(array_merge($validated, [
            'status' => 'baru',
        ]));

        return response()->json([
            'status' => 'success',
            'message' => 'Reservasi berhasil dikirim! Kami akan segera memproses pesanan Anda.'
        ]);
    }
}
