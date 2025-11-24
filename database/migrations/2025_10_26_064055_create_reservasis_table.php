<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('jumlah_orang');

            $table->foreignId('meja_id')
                  ->constrained('mejas')
                  ->cascadeOnDelete();

            $table->date('tanggal');
            $table->time('jam');
            $table->text('catatan')->nullable();

            // Status hanya 2 opsi: dipesan dan dibatalkan
            $table->enum('status', ['dipesan', 'dibatalkan'])
                  ->default('dipesan');

            $table->timestamps();

            $table->engine = 'InnoDB';
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasis');
    }
};
