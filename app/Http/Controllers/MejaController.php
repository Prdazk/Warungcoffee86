<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MejaController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal', now()->format('Y-m-d'));
        $jam = $request->input('jam', now()->format('H:i'));

        $mejas = Meja::orderBy('id', 'asc')->get();

        foreach ($mejas as $meja) {

            $totalOrang = $meja->reservasis()
                ->where('tanggal', $tanggal)
                ->where('jam', $jam)
                ->where('status', 'Dipesan')
                ->sum('jumlah_orang');

            if ($totalOrang == 0) {
                $meja->status_meja = 'Kosong';
            } elseif ($totalOrang < $meja->kapasitas) {
                $meja->status_meja = 'Terisi';
            } else {
                $meja->status_meja = 'Dipesan';
            }

            $reservasi = $meja->reservasis()
                ->where('tanggal', $tanggal)
                ->where('jam', $jam)
                ->whereIn('status', ['Dipesan', 'Terisi'])
                ->first();

            $meja->nama_pemesan = $reservasi->nama ?? '-';
        }

        return view('admin.reservasi.tambah-meja', compact('mejas', 'tanggal', 'jam'));
    }

    public function store(Request $request)
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

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Meja baru berhasil ditambahkan!',
                'data' => $meja
            ]);
        }

        return back()->with('success', 'Meja baru berhasil ditambahkan!');
    }

    public function destroy(Meja $meja)
    {
        DB::transaction(function () use ($meja) {
            $meja->reservasis()->delete();
            $meja->delete();
        });

        return back()->with('success', 'Meja berhasil dihapus!');
    }
}