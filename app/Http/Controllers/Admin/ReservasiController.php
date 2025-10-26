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
    public function index()
    {
        $reservasis = Reservasi::with('meja')->latest()->get();
        $mejas = Meja::orderBy('id', 'asc')->get();

        // Update status meja otomatis berdasarkan reservasi hari ini
        $today = now()->format('Y-m-d');
        $mejaIdsDipesan = Reservasi::whereDate('tanggal', $today)
            ->where('status', 'Dipesan')
            ->pluck('meja_id')
            ->toArray();

        foreach ($mejas as $meja) {
            $meja->update([
                'status_meja' => in_array($meja->id, $mejaIdsDipesan)
                    ? 'Dipesan'
                    : 'Kosong'
            ]);
        }

        return view('admin.reservasi.index', compact('reservasis', 'mejas'));
    }

    /**
     * ➕ Tambah meja baru
     */
    public function storeMeja(Request $request)
    {
        $request->validate([
            'nama_meja' => 'required|string|max:100|unique:mejas,nama_meja',
            'kapasitas' => 'nullable|integer|min:1|max:20',
        ]);

        Meja::create([
            'nama_meja' => ucfirst($request->nama_meja),
            'kapasitas' => $request->kapasitas ?? 4,
            'status_meja' => 'Kosong',
        ]);

        return back()->with('success', 'Meja berhasil ditambahkan.');
    }

    /**
     * ✏️ Update data meja
     */
    public function updateMeja(Request $request, $id)
    {
        $request->validate([
            'nama_meja' => 'required|string|max:100|unique:mejas,nama_meja,' . $id,
            'kapasitas' => 'required|integer|min:1|max:20',
            'status_meja' => 'required|in:Kosong,Dipesan',
        ]);

        $meja = Meja::findOrFail($id);
        $meja->update([
            'nama_meja' => ucfirst($request->nama_meja),
            'kapasitas' => $request->kapasitas,
            'status_meja' => $request->status_meja,
        ]);

        return back()->with('success', 'Meja berhasil diperbarui.');
    }

    /**
     * 🗑️ Hapus reservasi (non-AJAX)
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $reservasi = Reservasi::findOrFail($id);

            // Kembalikan status meja menjadi Kosong
            if ($reservasi->meja_id) {
                Meja::where('id', $reservasi->meja_id)->update(['status_meja' => 'Kosong']);
            }

            $reservasi->delete();

            DB::commit();

            // Redirect biasa, tidak JSON
            return redirect()->route('admin.reservasi.index')
                ->with('success', 'Reservasi berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.reservasi.index')
                ->with('error', 'Terjadi kesalahan saat menghapus reservasi.');
        }
    }

    /**
     * 🔧 Update reservasi (AJAX optional)
     */
    public function update(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah_orang' => 'required|integer|min:1|max:10',
            'meja_id' => 'required|exists:mejas,id',
            'tanggal' => 'required|date|after_or_equal:' . now()->format('Y-m-d'),
            'jam' => 'required',
            'catatan' => 'nullable|string|max:500',
            'status' => 'required|in:Dipesan,Dibatalkan',
        ]);

        DB::beginTransaction();
        try {
            // Update status meja lama jika ganti meja
            if ($request->meja_id != $reservasi->meja_id) {
                if ($reservasi->meja_id) {
                    Meja::where('id', $reservasi->meja_id)->update(['status_meja' => 'Kosong']);
                }
                Meja::where('id', $request->meja_id)
                    ->update(['status_meja' => $request->status === 'Dipesan' ? 'Dipesan' : 'Kosong']);
            } else {
                Meja::where('id', $reservasi->meja_id)
                    ->update(['status_meja' => $request->status === 'Dipesan' ? 'Dipesan' : 'Kosong']);
            }

            $reservasi->update([
                'nama' => $request->nama,
                'jumlah_orang' => $request->jumlah_orang,
                'meja_id' => $request->meja_id,
                'tanggal' => $request->tanggal,
                'jam' => $request->jam,
                'catatan' => $request->catatan,
                'status' => $request->status,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => $reservasi->load('meja')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui reservasi.'
            ], 500);
        }
    }
}
