<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AdminData extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admin_data';

    protected $fillable = [
        'nama',
        'email',
        'role', // admin / superadmin
        'no_hp',
        'password',
        'status',  // 1 = aktif, 0 = nonaktif
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
