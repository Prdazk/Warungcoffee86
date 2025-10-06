<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    // kolom yang boleh diisi
    protected $fillable = ['email', 'password'];

    // sembunyikan password saat di-query
    protected $hidden = ['password'];
}
