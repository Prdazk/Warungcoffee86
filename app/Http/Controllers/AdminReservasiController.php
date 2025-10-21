<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;

class AdminReservasiController extends Controller
{
    /**
     * Menampilkan semua reservasi terbaru.
     */
    public function index()
    {
        // Ambil semua reservasi terbaru dulu
        $reservasis = Reservasi::latest()->get();

        // Hitung jumlah reservasi baru (status = 'baru')
        $jumlahBaru = Reservasi::where('status', 'baru')->count();

        return view('admin.reservasi', compact('reservasis', 'jumlahBaru'));
    }

    /**
     * Menghapus reservasi berdasarkan ID.
     */
    public function destroy($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->delete();

        return redirect()->route('admin.reservasi.index')
                         ->with('success', 'Reservasi berhasil dihapus!');
    }

    /**
     * Static helper: menghitung jumlah reservasi baru.
     * Bisa dipanggil di provider atau view composer jika diperlukan.
     */
    public static function countNew()
    {
        return Reservasi::where('status', 'baru')->count();
    }
}
