<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proyeks', function (Blueprint $table) {

            $table->id();

            $table->string('kode_proyek')->unique();

            $table->string('nama_proyek');

            $table->string('kegiatan');

            $table->string('sub_kegiatan');

            $table->string('pekerjaan');

            $table->string('lokasi');

            $table->string('kontraktor');

            $table->string('konsultan')->nullable();

            $table->string('pic');

            $table->enum('status',[
                'Aktif',
                'Selesai'
            ])->default('Aktif');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyeks');
    }
};