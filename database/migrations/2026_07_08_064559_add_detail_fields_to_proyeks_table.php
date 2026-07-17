<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proyeks', function (Blueprint $table) {

            if (!Schema::hasColumn('proyeks', 'pic')) {
                $table->string('pic')->nullable();
            }

        });
    }

    public function down(): void
    {
        Schema::table('proyeks', function (Blueprint $table) {

            if (Schema::hasColumn('proyeks', 'pic')) {
                $table->dropColumn('pic');
            }

        });
    }
};