<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\Meja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservasiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tanggal = $request->input('tanggal', now()->format('Y-m-d'));
        $jam = $request->input('jam', now()->format('H:i'));

        $mejas = Meja::orderBy('id')->get();

        if ($mejas->isEmpty()) {
            Meja::create([
                'nama_meja' => 'Meja 1',
                'kapasitas' => 4,
                'status_meja' => 'Kosong',
            ]);
            $mejas = Meja::orderBy('id')->get();
        }

        $reservasis = Reservasi::with('meja')->latest();

        if ($search) {
            $reservasis->where('nama', 'like', "%{$search}%");
        }

        $reservasis = $reservasis->get();

        foreach ($mejas as $meja) {
            $reservasiAktif = $meja->reservasis()
                ->where('status', 'Dipesan')
                ->where('tanggal', $tanggal)
                ->where('jam', $jam)
                ->exists();

            $meja->status_sekarang = $reservasiAktif ? 'Terpakai' : $meja->status_meja;
        }


        return view(
            'admin.reservasi.index',
            compact('reservasis', 'mejas', 'search', 'tanggal', 'jam')
        );
    }

    public function latest()
    {
        $reservasis = Reservasi::with('meja')
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $reservasis
        ]);
    }
    public function storeMeja(Request $request)
    {
        $request->validate([
            'nama_meja' => 'required|string|max:100|unique:mejas,nama_meja',
            'kapasitas' => 'nullable|integer|min:1|max:20',
        ]);

        $meja = Meja::create([
            'nama_meja' => ucfirst($request->nama_meja),
            'kapasitas' => $request->kapasitas ?? 4,
            'status_meja' => 'Kosong',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Meja berhasil ditambahkan!',
            'data' => $meja
        ]);
    }
    public function updateMeja(Request $request, $id)
    {
        $request->validate([
            'nama_meja' => 'required|string|max:100|unique:mejas,nama_meja,' . $id,
            'kapasitas' => 'required|integer|min:1|max:20',
        ]);

        $meja = Meja::findOrFail($id);

        $meja->update([
            'nama_meja' => ucfirst($request->nama_meja),
            'kapasitas' => $request->kapasitas,
        ]);

        return back()->with('success', 'Meja berhasil diperbarui.');
    }
    public function destroyMeja($id)
    {
        $meja = Meja::findOrFail($id);

        DB::transaction(function () use ($meja) {
            $meja->reservasis()->delete();
            $meja->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'Meja berhasil dihapus.'
        ]);
    }
    public function destroy($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        if ($reservasi->meja_id) {
            Meja::where('id', $reservasi->meja_id)
                ->update(['status_meja' => 'Kosong']);
        }

        $reservasi->delete();

        return redirect()->route('admin.reservasi.index')
            ->with('success', 'Reservasi berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah_orang' => 'required|integer|min:1|max:' . $reservasi->meja->kapasitas,
            'meja_id' => 'required|exists:mejas,id',
            'tanggal' => 'required|date|after_or_equal:' . now()->format('Y-m-d'),
            'jam' => 'required',
            'catatan' => 'nullable|string|max:500',
            'status' => 'required|in:Dipesan,Dibatalkan',
        ]);

        DB::transaction(function () use ($request, $reservasi) {

            $oldMejaId  = $reservasi->meja_id;
            $newMejaId  = $request->meja_id;
            $newStatus  = $request->status;

            if ($oldMejaId != $newMejaId && $oldMejaId) {
                Meja::where('id', $oldMejaId)->update([
                    'status_meja' => 'Kosong'
                ]);
            }

            Meja::where('id', $newMejaId)->update([
                'status_meja' => $newStatus === 'Dipesan' ? 'Terpakai' : 'Kosong'
            ]);

            $reservasi->update(
                $request->only(['nama', 'jumlah_orang', 'meja_id', 'tanggal', 'jam', 'catatan', 'status'])
            );

            if ($newStatus === 'Dibatalkan') {
                Meja::where('id', $newMejaId)->update([
                    'status_meja' => 'Kosong'
                ]);
            }
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Reservasi berhasil diperbarui.',
            'data' => $reservasi->load('meja')
        ]);
    }
    public function storeReservasi(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah_orang' => 'required|integer|min:1|max:10',
            'meja_id' => 'required|exists:mejas,id',
            'tanggal' => 'required|date|after_or_equal:' . now()->format('Y-m-d'),
            'jam' => 'required',
            'catatan' => 'nullable|string|max:500',
            'status' => 'required|in:baru,Dipesan,selesai,Dibatalkan',
        ]);

        try {
            $reservasi = DB::transaction(function () use ($request) {

                $meja = Meja::findOrFail($request->meja_id);

                if ($request->jumlah_orang > $meja->kapasitas) {
                    throw new \Exception('Jumlah orang melebihi kapasitas meja!');
                }

                $meja->status_meja = $request->status === 'Dipesan' ? 'Terpakai' : 'Kosong';
                $meja->save();

                return Reservasi::create(
                    $request->only([
                        'nama',
                        'jumlah_orang',
                        'meja_id',
                        'tanggal',
                        'jam',
                        'catatan',
                        'status'
                    ])
                );
            });

            return response()->json([
                'success' => true,
                'message' => 'Reservasi berhasil ditambahkan.',
                'data' => $reservasi->load('meja')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?? 'Terjadi kesalahan saat menambahkan reservasi.'
            ], 400);
        }
    }

        public function availableMeja(Request $request)
    {
        $tanggal = $request->query('tanggal');
        $jam = $request->query('jam');

        if (!$tanggal || !$jam) {
            return response()->json(['error' => 'Tanggal dan jam wajib diisi.'], 400);
        }

        // Ambil ID meja yang sudah terpakai pada waktu yang sama
        $usedMeja = Reservasi::where('tanggal', $tanggal)
            ->where('jam', $jam)
            ->where('status', 'Dipesan')
            ->pluck('meja_id');

        // Ambil meja yang statusnya tidak terpakai
        $mejas = Meja::whereNotIn('id', $usedMeja)->get(['id', 'nama_meja']);

        return response()->json($mejas);
    }


        public function notifCount()
        {
            $count = Reservasi::whereDate('created_at', today())->count();

            return response()->json([
                'status' => 'success',
                'count' => $count
            ]);
        }

}