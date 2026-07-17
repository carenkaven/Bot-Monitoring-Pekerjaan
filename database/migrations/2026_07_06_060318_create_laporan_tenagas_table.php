<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_tenagas', function (Blueprint $table) {

            $table->id();

            $table->foreignId('laporan_id')
                  ->constrained('laporans')
                  ->cascadeOnDelete();

            $table->integer('pekerja')->default(0);

            $table->integer('tukang')->default(0);

            $table->integer('mandor')->default(0);

            $table->integer('pelaksana')->default(0);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_tenagas');
    }
};