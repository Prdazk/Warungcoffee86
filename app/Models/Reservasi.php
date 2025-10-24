<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jumlah_orang',
        'pilihan_meja',
        'tanggal',
        'jam',
        'catatan',
        'status',
    ];
}
