<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('karyawan_id')
                ->constrained('karyawans')
                ->cascadeOnDelete();

            /* ============ Project info (denormalized, dikirim oleh WA Bot) ============ */
            $table->string('nama_proyek');
            $table->string('kegiatan');
            $table->string('sub_kegiatan')->nullable();
            $table->string('pekerjaan');
            $table->string('lokasi');
            $table->string('kontraktor')->nullable();
            $table->string('konsultan')->nullable();
            $table->string('pic')->nullable();
            $table->string('minggu_ke')->nullable();

            /* ============ Report meta ============ */
            $table->date('tanggal')->index();
            $table->text('catatan')->nullable();

            $table->enum('status', ['Menunggu', 'Disetujui', 'Ditolak'])
                ->default('Menunggu')
                ->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
