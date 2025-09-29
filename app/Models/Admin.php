<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['username', 'password']; // kolom yang bisa diisi massal
    protected $hidden = ['password']; // agar password tidak muncul saat query
}
