<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Meja;
use Illuminate\Support\Facades\DB;

class ReservasiController extends Controller
{
    /**
     * Simpan reservasi (User)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah_orang' => 'required|integer|min:1|max:6',
            'tanggal' => 'required|date|after_or_equal:today',
            'jam' => 'required',
            'meja_id' => 'required|exists:mejas,id',
            'catatan' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            $meja = Meja::lockForUpdate()->findOrFail($validated['meja_id']);

            // Cek ketersediaan berdasarkan reservasi aktif
            $sudahDipesan = Reservasi::where('meja_id', $meja->id)
                ->where('tanggal', $validated['tanggal'])
                ->where('jam', $validated['jam'])
                ->where('status', 'Dipesan')
                ->exists();

            if ($meja->status_meja !== 'Kosong' || $sudahDipesan) {
                throw new \Exception('Meja ini sedang tidak tersedia, silakan pilih meja lain.');
            }

            $reservasi = Reservasi::create([
                'nama' => $validated['nama'],
                'jumlah_orang' => $validated['jumlah_orang'],
                'meja_id' => $meja->id,
                'tanggal' => $validated['tanggal'],
                'jam' => $validated['jam'],
                'catatan' => $validated['catatan'] ?? null,
                'status' => 'Dipesan',
            ]);

            $meja->update(['status_meja' => 'Dipesan']);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Reservasi berhasil dikirim.',
                'data' => $reservasi
            ]);
        } catch (\Exception $error) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $error->getMessage()
            ], 400);
        }
    }

    /**
     * Ambil daftar meja yang tersedia (AJAX)
     */
    public function availableMeja(Request $request)
    {
        $tanggal = $request->query('tanggal');
        $jam = $request->query('jam');

        if (!$tanggal || !$jam) {
            return response()->json(['error' => 'Tanggal dan jam diperlukan.'], 400);
        }

        $mejas = Meja::orderBy('id')->get()->map(function ($meja) use ($tanggal, $jam) {
            $digunakan = Reservasi::where('meja_id', $meja->id)
                ->where('tanggal', $tanggal)
                ->where('jam', $jam)
                ->where('status', 'Dipesan')
                ->exists();

            return [
                'id' => $meja->id,
                'nama_meja' => $meja->nama_meja,
                'status_meja' => $digunakan ? 'Terpakai' : 'Kosong',
            ];
        });

        return response()->json($mejas);
    }

    /**
     * Update reservasi
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah_orang' => 'required|integer|min:1|max:6',
            'tanggal' => 'required|date|after_or_equal:today',
            'jam' => 'required',
            'meja_id' => 'required|exists:mejas,id',
            'catatan' => 'nullable|string|max:500',
            'status' => 'required|in:Dipesan,Dibatalkan',
        ]);

        DB::beginTransaction();
        try {
            $reservasi = Reservasi::lockForUpdate()->findOrFail($id);

            // Jika meja diganti
            if ($reservasi->meja_id != $validated['meja_id']) {
                $mejaBaru = Meja::lockForUpdate()->findOrFail($validated['meja_id']);

                if ($mejaBaru->status_meja !== 'Kosong') {
                    throw new \Exception('Meja baru sedang tidak tersedia.');
                }

                Meja::where('id', $reservasi->meja_id)->update(['status_meja' => 'Kosong']);
                $mejaBaru->update(['status_meja' => 'Dipesan']);
            }

            $reservasi->update($validated);

            if ($validated['status'] === 'Dibatalkan') {
                Meja::where('id', $reservasi->meja_id)->update(['status_meja' => 'Kosong']);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Reservasi berhasil diperbarui.',
                'data' => $reservasi
            ]);
        } catch (\Exception $error) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $error->getMessage()
            ], 400);
        }
    }

    /**
     * Hapus reservasi
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $reservasi = Reservasi::findOrFail($id);

            Meja::where('id', $reservasi->meja_id)->update(['status_meja' => 'Kosong']);
            $reservasi->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Reservasi berhasil dibatalkan.'
            ]);
        } catch (\Exception $error) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membatalkan reservasi.'
            ], 500);
        }
    }
}
