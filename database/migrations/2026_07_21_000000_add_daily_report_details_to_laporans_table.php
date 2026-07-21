<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            if (!Schema::hasColumn('laporans', 'jam_mulai')) {
                $table->string('jam_mulai')->nullable()->after('progress');
            }
            if (!Schema::hasColumn('laporans', 'jam_selesai')) {
                $table->string('jam_selesai')->nullable()->after('jam_mulai');
            }
            if (!Schema::hasColumn('laporans', 'kendala')) {
                $table->text('kendala')->nullable()->after('cuaca');
            }
            if (!Schema::hasColumn('laporans', 'rencana_besok')) {
                $table->text('rencana_besok')->nullable()->after('kendala');
            }
            if (!Schema::hasColumn('laporans', 'keterangan')) {
                $table->text('keterangan')->nullable()->after('rencana_besok');
            }
        });
    }

    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn(['jam_mulai', 'jam_selesai', 'kendala', 'rencana_besok', 'keterangan']);
        });
    }
};
