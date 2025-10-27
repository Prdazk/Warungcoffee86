<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\Meja;
use Illuminate\Http\Request;

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
                'status_meja' => in_array($meja->id, $mejaIdsDipesan) ? 'Dipesan' : 'Kosong'
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
     * 🗑️ Hapus reservasi
     */
    public function destroy($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        // Kembalikan status meja menjadi Kosong
        if ($reservasi->meja_id) {
            Meja::where('id', $reservasi->meja_id)->update(['status_meja' => 'Kosong']);
        }

        $reservasi->delete();

        return redirect()->route('admin.reservasi.index')
                         ->with('success', 'Reservasi berhasil dihapus.');
    }

    /**
     * 🔧 Update reservasi (AJAX) - sukses semua
     */
    public function update(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);

        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah_orang' => 'required|integer|min:1|max:10',
            'meja_id' => 'required|exists:mejas,id',
            'tanggal' => 'required|date|after_or_equal:' . now()->format('Y-m-d'),
            'jam' => 'required',
            'catatan' => 'nullable|string|max:500',
            'status' => 'required|in:baru,Dipesan,selesai,batal',
        ]);

        $oldMejaId = $reservasi->meja_id;
        $newMejaId = $request->meja_id;
        $status = $request->status;

        // Update status meja lama jika pindah meja
        if ($oldMejaId != $newMejaId) {
            if ($oldMejaId) {
                Meja::where('id', $oldMejaId)->update(['status_meja' => 'Kosong']);
            }
            Meja::where('id', $newMejaId)
                ->update(['status_meja' => $status === 'Dipesan' ? 'Dipesan' : 'Kosong']);
        } else {
            // Tetap di meja yang sama, update status meja sesuai status reservasi
            Meja::where('id', $newMejaId)
                ->update(['status_meja' => $status === 'Dipesan' ? 'Dipesan' : 'Kosong']);
        }

        // Update data reservasi
        $reservasi->update([
            'nama' => $request->nama,
            'jumlah_orang' => $request->jumlah_orang,
            'meja_id' => $request->meja_id,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'catatan' => $request->catatan,
            'status' => $request->status,
        ]);

        // Response sukses
        return response()->json([
            'status' => 'success',
            'message' => 'Reservasi berhasil diperbarui.',
            'data' => $reservasi->load('meja')
        ]);
    }
}
