<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Meja;

class ReservasiController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah_orang' => 'required|integer|min:1|max:10',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'pilihan_meja' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $validated['status'] = 'baru';
        Reservasi::create($validated);

        // Tandai meja jadi Terpakai
        $meja = Meja::where('nama_meja', $validated['pilihan_meja'])->first();
        if($meja){
            $meja->status_meja = 'Terpakai';
            $meja->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Reservasi berhasil dikirim! Kami akan segera memproses pesanan Anda.'
        ]);
    }
}
