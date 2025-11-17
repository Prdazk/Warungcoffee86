<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;

class AdminReservasiController extends Controller
{
    public function index()
    {
        $reservasis = Reservasi::latest()->get();

        $jumlahBaru = Reservasi::where('status', 'baru')->count();

        return view('admin.reservasi', compact('reservasis', 'jumlahBaru'));
    }
    public function destroy($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->delete();

        return redirect()->route('admin.reservasi.index')
                         ->with('success', 'Reservasi berhasil dihapus!');
    }

    public static function countNew()
    {
        return Reservasi::where('status', 'baru')->count();
    }
}