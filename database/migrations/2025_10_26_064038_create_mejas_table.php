<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mejas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_meja')->unique();
            $table->integer('kapasitas')->default(4);
            $table->enum('status_meja', ['Kosong','Dipesan','Terisi'])->default('Kosong');
            $table->timestamps();
            $table->index('status_meja');
            $table->engine = 'InnoDB';
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mejas');
    }
};
