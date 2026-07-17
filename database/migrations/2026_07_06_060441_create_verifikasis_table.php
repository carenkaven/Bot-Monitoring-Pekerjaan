<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verifikasis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('laporan_id')
                ->constrained('laporans')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->enum('status', ['Disetujui', 'Ditolak'])->index();

            $table->text('catatan')->nullable();

            $table->timestamp('tanggal_verifikasi')->nullable();

            $table->timestamps();

            $table->unique('laporan_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verifikasis');
    }
};
