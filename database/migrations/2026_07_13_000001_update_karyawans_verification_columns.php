<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Refactor `karyawans.status` so it matches the auth/verification flow:
     * pending -> aktif -> nonaktif / ditolak (all lowercase), and add the
     * columns needed to track admin verification of a karyawan account.
     */
    public function up(): void
    {
        // 1) Widen the column to a plain string first so existing values
        //    ("Aktif" / "Nonaktif") are preserved while we normalise them.
        //    Done via raw SQL to avoid requiring doctrine/dbal for a
        //    ->change() on an enum column.
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE karyawans MODIFY status VARCHAR(20) NOT NULL DEFAULT 'pending'");
        }

        // 2) Normalise existing data to lowercase values used by the app.
        DB::table('karyawans')->where('status', 'Aktif')->update(['status' => 'aktif']);
        DB::table('karyawans')->where('status', 'Nonaktif')->update(['status' => 'nonaktif']);
        DB::table('karyawans')->where('status', 'Pending')->update(['status' => 'pending']);
        DB::table('karyawans')->where('status', 'Ditolak')->update(['status' => 'ditolak']);

        // 3) Lock the column back down to the final enum set.
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE karyawans MODIFY status ENUM('pending','aktif','nonaktif','ditolak') NOT NULL DEFAULT 'pending'");
        }

        Schema::table('karyawans', function (Blueprint $table) {
            if (!Schema::hasColumn('karyawans', 'is_verified')) {
                $table->boolean('is_verified')->default(false)->after('status');
            }

            if (!Schema::hasColumn('karyawans', 'verified_by')) {
                $table->foreignId('verified_by')
                    ->nullable()
                    ->after('is_verified')
                    ->constrained('users')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('karyawans', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('verified_by');
            }
        });

        // Existing "aktif" karyawans (created before this refactor) are
        // treated as already verified so they are not locked out.
        DB::table('karyawans')
            ->where('status', 'aktif')
            ->where('is_verified', false)
            ->update(['is_verified' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            if (Schema::hasColumn('karyawans', 'verified_by')) {
                $table->dropConstrainedForeignId('verified_by');
            }

            if (Schema::hasColumn('karyawans', 'verified_at')) {
                $table->dropColumn('verified_at');
            }

            if (Schema::hasColumn('karyawans', 'is_verified')) {
                $table->dropColumn('is_verified');
            }
        });

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE karyawans MODIFY status ENUM('Aktif','Nonaktif') NOT NULL DEFAULT 'Aktif'");
        }
    }
};
