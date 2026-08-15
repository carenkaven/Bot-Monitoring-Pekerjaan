<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporan_tenagas', function (Blueprint $table) {
            if (!Schema::hasColumn('laporan_tenagas', 'jenis_tenaga')) {
                $table->string('jenis_tenaga')->nullable()->after('laporan_id');
            }
            if (!Schema::hasColumn('laporan_tenagas', 'jumlah')) {
                $table->integer('jumlah')->nullable()->after('jenis_tenaga');
            }
            if (!Schema::hasColumn('laporan_tenagas', 'satuan')) {
                $table->string('satuan')->nullable()->after('jumlah');
            }
        });
    }

    public function down(): void
    {
        Schema::table('laporan_tenagas', function (Blueprint $table) {
            $columns = array_filter(['jenis_tenaga', 'jumlah', 'satuan'], fn ($column) => Schema::hasColumn('laporan_tenagas', $column));
            if ($columns) $table->dropColumn($columns);
        });
    }
};
