<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminData extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admins_data';

    protected $fillable = [
        'nama',
        'email',
        'jabatan',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
