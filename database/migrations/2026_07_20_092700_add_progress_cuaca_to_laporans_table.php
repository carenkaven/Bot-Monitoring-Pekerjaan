<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            if (!Schema::hasColumn('laporans', 'progress')) {
                $table->integer('progress')->nullable()->after('tanggal');
            }
            if (!Schema::hasColumn('laporans', 'cuaca')) {
                $table->string('cuaca')->nullable()->after('catatan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn(['progress', 'cuaca']);
        });
    }
};
