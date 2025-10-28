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
     * Bisa difilter berdasarkan nama via GET parameter "search"
     */
        public function index(Request $request)
    {
        $search = $request->input('search');

        // Ambil semua meja
        $mejas = Meja::orderBy('id')->get();

        // Jika belum ada meja sama sekali, buat 1 meja dummy
        if ($mejas->isEmpty()) {
            $dummyMeja = Meja::create([
                'nama_meja' => 'Meja 1',
                'kapasitas' => 4,
                'status_meja' => 'Kosong',
            ]);
            $mejas = Meja::orderBy('id')->get();
        }

        // Query reservasi
        $reservasis = Reservasi::with('meja')->latest();
        if ($search) {
            $reservasis->where('nama', 'like', "%{$search}%");
        }
        $reservasis = $reservasis->get();

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

        return view('admin.reservasi.index', compact('reservasis', 'mejas', 'search'));
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
     * 🗑️ Hapus meja permanen
     */
    public function destroyMeja($id)
    {
        $meja = Meja::findOrFail($id);

        // Hapus semua reservasi terkait meja ini (opsional)
        Reservasi::where('meja_id', $id)->delete();

        $meja->delete();

        return response()->json([
            'success' => true,
            'message' => 'Meja berhasil dihapus.'
        ]);
    }

    /**
     * 🗑️ Hapus reservasi
     */
    public function destroy($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        if ($reservasi->meja_id) {
            Meja::where('id', $reservasi->meja_id)->update(['status_meja' => 'Kosong']);
        }

        $reservasi->delete();

        return redirect()->route('admin.reservasi.index')
                         ->with('success', 'Reservasi berhasil dihapus.');
    }

    /**
     * 🔧 Update reservasi (AJAX)
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
            'status' => 'required|in:baru,Dipesan,selesai,batal',
        ]);

        $oldMejaId = $reservasi->meja_id;
        $newMejaId = $request->meja_id;
        $status = $request->status;

        // Update status meja lama jika pindah meja
        if ($oldMejaId != $newMejaId) {
            if ($oldMejaId) Meja::where('id', $oldMejaId)->update(['status_meja' => 'Kosong']);
            Meja::where('id', $newMejaId)->update(['status_meja' => $status === 'Dipesan' ? 'Dipesan' : 'Kosong']);
        } else {
            Meja::where('id', $newMejaId)->update(['status_meja' => $status === 'Dipesan' ? 'Dipesan' : 'Kosong']);
        }

        $reservasi->update($request->only(['nama','jumlah_orang','meja_id','tanggal','jam','catatan','status']));

        return response()->json([
            'status' => 'success',
            'message' => 'Reservasi berhasil diperbarui.',
            'data' => $reservasi->load('meja')
        ]);
    }

    /**
     * ➕ Tambah reservasi baru
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
            'status' => 'required|in:baru,Dipesan,selesai,batal',
        ]);

        Meja::where('id', $request->meja_id)
            ->update(['status_meja' => $request->status === 'Dipesan' ? 'Dipesan' : 'Kosong']);

        Reservasi::create($request->only(['nama','jumlah_orang','meja_id','tanggal','jam','catatan','status']));

        return back()->with('success', 'Reservasi berhasil ditambahkan.');
    }
}
