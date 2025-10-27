<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminData;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan tabel sebelum isi ulang
        AdminData::truncate();

        // Superadmin utama
        AdminData::create([
            'nama' => 'Superadmin Utama',
            'email' => 'superadmin@gmail.com',
            'jabatan' => 'Superadmin',
            'no_hp' => '081234567890',
            'role' => 'superadmin',
            'password' => Hash::make('sehatselalu'),
        ]);

        // Admin standar
        AdminData::create([
            'nama' => 'Admin Standar',
            'email' => 'admin@gmail.com',
            'jabatan' => 'Admin',
            'no_hp' => '089876543210',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
        ]);
    }
}
