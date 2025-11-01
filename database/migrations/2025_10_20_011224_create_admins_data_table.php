<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('admin_data', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('jabatan')->nullable(); // admin / superadmin
            $table->string('role')->default('admin'); // otomatis sama dengan jabatan
            $table->string('no_hp', 20)->nullable();
            $table->tinyInteger('status')->default(0); // 1 = aktif, 0 = nonaktif
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_data');
    }
};
