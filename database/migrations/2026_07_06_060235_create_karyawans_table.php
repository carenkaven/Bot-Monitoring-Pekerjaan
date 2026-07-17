<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();

            $table->string('nama', 100);
            $table->string('jabatan', 100);
            $table->string('no_hp', 20)->unique();
            $table->string('email')->nullable();

            $table->enum('status', [
                'Aktif',
                'Nonaktif'
            ])->default('Aktif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};