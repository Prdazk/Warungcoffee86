<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Meja;
use Illuminate\Support\Facades\DB;

class ReservasiController extends Controller
{
    /**
     * Simpan data reservasi dari user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah_orang' => 'required|integer|min:1|max:10',
            'tanggal' => 'required|date|after_or_equal:today',
            'jam' => 'required',
            'meja_id' => 'required|exists:mejas,id',
            'catatan' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            $meja = Meja::lockForUpdate()->find($validated['meja_id']);
            if (!$meja) {
                throw new \Exception('Meja tidak ditemukan!');
            }

            if ($meja->status_meja !== 'Kosong') {
                throw new \Exception('Meja ini sedang tidak tersedia, silakan pilih meja lain.');
            }

            // Buat reservasi
            $reservasi = Reservasi::create([
                'nama' => $validated['nama'],
                'jumlah_orang' => $validated['jumlah_orang'],
                'meja_id' => $meja->id,
                'tanggal' => $validated['tanggal'],
                'jam' => $validated['jam'],
                'catatan' => $validated['catatan'] ?? null,
                'status' => 'Dipesan',
            ]);

            // Update status meja
            $meja->update(['status_meja' => 'Dipesan']);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Reservasi berhasil dikirim! Kami akan segera memproses pesanan Anda.',
                'data' => $reservasi
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Ambil daftar meja yang tersedia untuk tanggal & jam tertentu
     */
    public function availableMeja(Request $request)
    {
        $tanggal = $request->query('tanggal');
        $jam = $request->query('jam');

        if (!$tanggal || !$jam) {
            return response()->json(['error' => 'Tanggal dan jam wajib diisi.'], 400);
        }

        $mejas = Meja::all()->map(function ($meja) use ($tanggal, $jam) {
            $reservasiAktif = Reservasi::where('meja_id', $meja->id)
                ->where('tanggal', $tanggal)
                ->where('jam', $jam)
                ->where('status', 'Dipesan')
                ->exists();

            return [
                'id' => $meja->id,
                'nama_meja' => $meja->nama_meja,
                'status_meja' => $reservasiAktif ? 'Dipesan' : 'Kosong',
            ];
        });

        return response()->json($mejas);
    }
}
