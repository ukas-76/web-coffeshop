<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('meja', function (Blueprint $table) {
            // Menambahkan kolom min_dp setelah kolom kapasitas dengan nilai default 0
            $table->integer('min_dp')->default(0)->after('kapasitas');
        });
    }

    public function down(): void
    {
        Schema::table('meja', function (Blueprint $table) {
            $table->dropColumn('min_dp');
        });
    }
};