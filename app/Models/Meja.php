<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    use HasFactory;

    protected $table = 'mejas';

    protected $fillable = [
        'nama_meja',
        'status_meja', // misal: 'kosong' atau 'terisi'
    ];

    /**
     * Relasi 1 meja ke banyak reservasi
     */
    public function reservasis()
    {
        return $this->hasMany(Reservasi::class, 'meja_id');
    }
}
