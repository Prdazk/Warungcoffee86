<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminData;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        AdminData::truncate();

        AdminData::create([
            'nama' => 'Superadmin Utama',
            'email' => 'superadmin@gmail.com',
            'jabatan' => 'Superadmin',
            'role' => 'superadmin',
            'password' => Hash::make('sehatselalu'), // <-- ganti di sini
        ]);

        AdminData::create([
            'nama' => 'Admin Standar',
            'email' => 'admin@gmail.com',
            'jabatan' => 'Admin',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
        ]);
    }
}
