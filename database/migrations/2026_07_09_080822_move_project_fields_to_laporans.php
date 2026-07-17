<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('laporans', function (Blueprint $table) {

        if (!Schema::hasColumn('laporans','lokasi')) {
            $table->string('lokasi')->nullable();
        }

        if (!Schema::hasColumn('laporans','kontraktor')) {
            $table->string('kontraktor')->nullable();
        }

        if (!Schema::hasColumn('laporans','konsultan')) {
            $table->string('konsultan')->nullable();
        }

        if (!Schema::hasColumn('laporans','pic')) {
            $table->string('pic')->nullable();
        }

        if (!Schema::hasColumn('laporans','minggu_ke')) {
            $table->string('minggu_ke')->nullable();
        }

    });

    if (Schema::hasColumn('laporans','proyek_id')) {

        Schema::table('laporans', function (Blueprint $table) {

            $table->dropForeign(['proyek_id']);

            $table->dropColumn('proyek_id');

        });

    }
}

    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {

            $table->dropColumn([
                'nama_proyek',
                'kegiatan',
                'sub_kegiatan',
                'pekerjaan',
                'lokasi',
                'kontraktor',
                'konsultan',
                'pic',
                'minggu_ke'
            ]);

        });
    }
};