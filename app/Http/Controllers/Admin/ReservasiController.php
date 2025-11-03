<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\Meja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservasiController extends Controller
{
    /**
     * 🧾 Tampilkan daftar reservasi & status meja
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tanggal = $request->input('tanggal', now()->format('Y-m-d'));
        $jam = $request->input('jam', now()->format('H:i'));

        $mejas = Meja::orderBy('id')->get();

        // Buat dummy meja jika kosong
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

        // Update status meja berdasarkan reservasi untuk tanggal & jam tertentu
        foreach ($mejas as $meja) {
            $aktif = $meja->reservasis()
                ->where('tanggal', $tanggal)
                ->where('jam', $jam)
                ->where('status', 'Dipesan')
                ->exists();

            $meja->status_meja = $aktif ? 'Terpakai' : 'Kosong';

            $reservasi = $meja->reservasis()
                ->where('tanggal', $tanggal)
                ->where('jam', $jam)
                ->where('status', 'Dipesan')
                ->first();
            $meja->nama_pemesan = $reservasi->nama ?? '-';
        }

        return view('admin.reservasi.index', compact('reservasis', 'mejas', 'search', 'tanggal', 'jam'));
    }

    /**
     * ➕ Tambah meja baru via AJAX
     */
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

        return $request->ajax() 
            ? response()->json(['success' => true, 'message' => 'Meja berhasil ditambahkan!', 'data' => $meja])
            : back()->with('success', 'Meja berhasil ditambahkan.');
    }

    /**
     * ✏️ Update data meja
     */
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

    /**
     * 🗑️ Hapus meja permanen via AJAX
     */
    public function destroyMeja($id)
    {
        $meja = Meja::findOrFail($id);
        DB::transaction(function () use ($meja) {
            $meja->reservasis()->delete();
            $meja->delete();
        });

        return response()->json(['success' => true, 'message' => 'Meja berhasil dihapus.']);
    }

    /**
     * 🗑️ Hapus reservasi
     */
    public function destroy($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        if ($reservasi->meja_id) {
            $meja = Meja::find($reservasi->meja_id);
            if ($meja) {
                $meja->status_meja = 'Kosong';
                $meja->save();
            }
        }
        $reservasi->delete();

        return redirect()->route('admin.reservasi.index')
                         ->with('success', 'Reservasi berhasil dihapus.');
    }

    /**
     * 🔧 Update reservasi via AJAX
     */
    public function update(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah_orang' => 'required|integer|min:1|max:'.$reservasi->meja->kapasitas,
            'meja_id' => 'required|exists:mejas,id',
            'tanggal' => 'required|date|after_or_equal:' . now()->format('Y-m-d'),
            'jam' => 'required',
            'catatan' => 'nullable|string|max:500',
            'status' => 'required|in:baru,Dipesan,selesai,Dibatalkan',
        ]);

        DB::transaction(function () use ($request, $reservasi) {
            $oldMejaId = $reservasi->meja_id;
            $newMejaId = $request->meja_id;
            $status = $request->status;

            if ($oldMejaId != $newMejaId) {
                if ($oldMejaId) Meja::where('id', $oldMejaId)->update(['status_meja' => 'Kosong']);
                Meja::where('id', $newMejaId)->update(['status_meja' => $status === 'Dipesan' ? 'Terpakai' : 'Kosong']);
            } else {
                Meja::where('id', $newMejaId)->update(['status_meja' => $status === 'Dipesan' ? 'Terpakai' : 'Kosong']);
            }

            $reservasi->update($request->only(['nama','jumlah_orang','meja_id','tanggal','jam','catatan','status']));
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Reservasi berhasil diperbarui.',
            'data' => $reservasi->load('meja')
        ]);
    }

    /**
     * ➕ Tambah reservasi baru via admin
     */
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

        DB::transaction(function () use ($request, &$reservasi) {
            $meja = Meja::findOrFail($request->meja_id);

            if ($request->jumlah_orang > $meja->kapasitas) {
                throw new \Exception('Jumlah orang melebihi kapasitas meja!');
            }

            $meja->status_meja = $request->status === 'Dipesan' ? 'Terpakai' : 'Kosong';
            $meja->save();

            $reservasi = Reservasi::create($request->only(['nama','jumlah_orang','meja_id','tanggal','jam','catatan','status']));
        });

        return response()->json([
            'success' => true,
            'message' => 'Reservasi berhasil ditambahkan.',
            'data' => $reservasi->load('meja')
        ]);
    }

    /**
     * 🔍 Endpoint untuk AJAX: daftar meja tersedia (Kosong/Terpakai)
     */
    public function availableMeja(Request $request)
    {
        $tanggal = $request->query('tanggal');
        $jam = $request->query('jam');

        if (!$tanggal || !$jam) {
            return response()->json(['error' => 'Tanggal dan jam wajib diisi.'], 400);
        }

        $mejas = Meja::all()->map(function ($meja) use ($tanggal, $jam) {
            $terpakai = Reservasi::where('meja_id', $meja->id)
                ->where('tanggal', $tanggal)
                ->where('jam', $jam)
                ->where('status', 'Dipesan')
                ->exists();

            return [
                'id' => $meja->id,
                'nama_meja' => $meja->nama_meja,
                'status_meja' => $terpakai ? 'Terpakai' : 'Kosong',
            ];
        });

        return response()->json($mejas);
    }
}
