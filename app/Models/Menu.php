<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    // Daftar kolom yang bisa diisi massal
    protected $fillable = ['name', 'description', 'price', 'image'];

    // Kalau mau pakai tabel singular "menu", uncomment baris ini:
    // protected $table = 'menu';
}
