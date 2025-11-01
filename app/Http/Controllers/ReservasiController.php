<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Meja;
use Illuminate\Support\Facades\DB;

class ReservasiController extends Controller
{
    /**
     * ➕ Simpan data reservasi dari user
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
            // Lock meja untuk mencegah double-booking
            $meja = Meja::lockForUpdate()->findOrFail($validated['meja_id']);

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

            // Update status meja jadi Dipesan
            $meja->update(['status_meja' => 'Dipesan']);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Reservasi berhasil dikirim!',
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
     * 🔍 Ambil daftar meja yang tersedia untuk tanggal & jam tertentu
     * Endpoint untuk AJAX refresh
     */
    public function availableMeja(Request $request)
    {
        $tanggal = $request->query('tanggal');
        $jam = $request->query('jam');

        if (!$tanggal || !$jam) {
            return response()->json(['error' => 'Tanggal dan jam wajib diisi.'], 400);
        }

        // Ambil semua meja dan cek status berdasarkan reservasi
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

    /**
     * 🔄 Update reservasi
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
                    throw new \Exception('Meja baru sedang tidak tersedia!');
                }

                // Kembalikan status meja lama
                Meja::where('id', $reservasi->meja_id)->update(['status_meja' => 'Kosong']);

                // Update status meja baru
                $mejaBaru->update(['status_meja' => 'Dipesan']);
            }

            // Update reservasi
            $reservasi->update([
                'nama' => $validated['nama'],
                'jumlah_orang' => $validated['jumlah_orang'],
                'meja_id' => $validated['meja_id'],
                'tanggal' => $validated['tanggal'],
                'jam' => $validated['jam'],
                'catatan' => $validated['catatan'] ?? null,
                'status' => $validated['status'],
            ]);

            // Jika dibatalkan, kembalikan status meja
            if ($validated['status'] === 'Dibatalkan') {
                Meja::where('id', $validated['meja_id'])->update(['status_meja' => 'Kosong']);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Reservasi berhasil diperbarui!',
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
     * 🗑️ Hapus reservasi
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $reservasi = Reservasi::findOrFail($id);

            // Kembalikan status meja
            if ($reservasi->meja_id) {
                Meja::where('id', $reservasi->meja_id)->update(['status_meja' => 'Kosong']);
            }

            $reservasi->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Reservasi berhasil dibatalkan.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membatalkan reservasi.'
            ], 500);
        }
    }
}
