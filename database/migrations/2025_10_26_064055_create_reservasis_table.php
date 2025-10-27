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

            // Foreign key ke meja
            $table->unsignedBigInteger('meja_id');
            $table->foreign('meja_id')->references('id')->on('mejas')->onDelete('cascade');

            $table->date('tanggal');
            $table->time('jam');
            $table->text('catatan')->nullable();
            $table->enum('status', ['baru','Dipesan','selesai','Dibatalkan'])->default('baru')->change();
            $table->timestamps();

            $table->engine = 'InnoDB';
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasis');
    }
};
