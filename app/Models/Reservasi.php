<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $table = 'reservasis';

    protected $fillable = [
        'nama',
        'jumlah_orang',
        'meja_id',
        'tanggal',
        'jam',
        'catatan',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam' => 'string', // agar jam bisa manual
    ];

    protected $attributes = [
        'status' => 'baru', // default reservasi baru
    ];

    /**
     * Relasi ke meja
     */
    public function meja()
    {
        return $this->belongsTo(Meja::class, 'meja_id');
    }

    /**
     * Scope: reservasi aktif hari ini
     */
    public function scopeAktif($query)
    {
        return $query->whereDate('tanggal', now()->format('Y-m-d'))
                     ->where('status', 'Dipesan');
    }
}
