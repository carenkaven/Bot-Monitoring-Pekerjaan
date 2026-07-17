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
        Schema::create('laporan_materials', function (Blueprint $table) {

            $table->id();

            $table->foreignId('laporan_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('nama_material');

            $table->decimal('volume', 8, 2);

            $table->string('satuan');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_materials');
    }
};