<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporans', function (Blueprint $table) {

            if (!Schema::hasColumn('laporans','nama_proyek')) {
                $table->string('nama_proyek')->nullable()->after('karyawan_id');
            }

            if (!Schema::hasColumn('laporans','kegiatan')) {
                $table->string('kegiatan')->nullable()->after('nama_proyek');
            }

            if (!Schema::hasColumn('laporans','sub_kegiatan')) {
                $table->string('sub_kegiatan')->nullable()->after('kegiatan');
            }

        });
    }

    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {

            $table->dropColumn([
                'nama_proyek',
                'kegiatan',
                'sub_kegiatan'
            ]);

        });
    }
};