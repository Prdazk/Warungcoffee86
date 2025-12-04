<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Meja;
use Illuminate\Support\Facades\DB;

class ReservasiController extends Controller
{
    /**
     * Tampilkan halaman reservasi
     */
    public function index()
    {
        // Ambil meja kosong untuk initial dropdown
        $mejaKosong = Meja::where('status_meja', 'Kosong')
            ->orderBy('id')
            ->get();

        return view('user.reservasi', compact('mejaKosong'));
    }

    /**
     * Simpan reservasi baru (AJAX)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah_orang' => 'required|integer|min:1|max:4',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'meja_id' => 'required|exists:mejas,id',
            'catatan' => 'nullable|string|max:500',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Simpan reservasi
                Reservasi::create([
                    'nama' => $request->nama,
                    'jumlah_orang' => $request->jumlah_orang,
                    'tanggal' => $request->tanggal,
                    'jam' => $request->jam,
                    'meja_id' => $request->meja_id,
                    'catatan' => $request->catatan,
                    'status' => 'Dipesan', // default status
                ]);

                // Update status meja menjadi 'Terisi'
                Meja::where('id', $request->meja_id)
                    ->update(['status_meja' => 'Terisi']);
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Reservasi berhasil!',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * API: daftar meja sesuai tanggal & jam
     */
   public function availableMeja(Request $request)
{
    $tanggal = $request->tanggal;
    $jam = $request->jam;

    // Jika jam belum dipilih → tampilkan semua meja dengan status Kosong
    if (!$jam) {
        return response()->json(
            Meja::where('status_meja', 'Kosong')
                ->orderBy('id')
                ->get()
        );
    }

    // Jika jam ada → cek meja yang digunakan
    $mejaDipakai = Reservasi::where('tanggal', $tanggal)
        ->where('jam', $jam)
        ->pluck('meja_id')
        ->toArray();

    // Ambil meja kosong + tidak dipakai pada tanggal & jam tsb
    $mejas = Meja::where('status_meja', 'Kosong')
        ->whereNotIn('id', $mejaDipakai)
        ->orderBy('id')
        ->get();

    return response()->json($mejas);
}


    /**
     * Update reservasi user
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

            if ($reservasi->meja_id != $validated['meja_id']) {
                $mejaBaru = Meja::lockForUpdate()->findOrFail($validated['meja_id']);

                $digunakan = Reservasi::where([
                    'meja_id' => $mejaBaru->id,
                    'tanggal' => $validated['tanggal'],
                    'jam' => $validated['jam'],
                    'status' => 'Dipesan',
                ])->exists();

                if ($digunakan) {
                    throw new \Exception('Meja baru sudah dipesan pada waktu tersebut.');
                }

                // Update status meja lama & baru
                Meja::where('id', $reservasi->meja_id)->update(['status_meja' => 'Kosong']);
                Meja::where('id', $validated['meja_id'])->update(['status_meja' => 'Terisi']);
            }

            $reservasi->update($validated);

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Reservasi berhasil diperbarui.',
                'data' => $reservasi,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Batalkan / hapus reservasi
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $reservasi = Reservasi::findOrFail($id);
            $mejaId = $reservasi->meja_id;

            $reservasi->delete();

            // Set meja kembali ke kosong
            Meja::where('id', $mejaId)->update(['status_meja' => 'Kosong']);

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Reservasi berhasil dibatalkan.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membatalkan reservasi.',
            ], 500);
        }
    }
}
