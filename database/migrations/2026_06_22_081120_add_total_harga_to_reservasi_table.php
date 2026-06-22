<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservasi', function (Blueprint $table) {
            // Menambahkan kolom total_harga setelah kolom total_tamu
            $table->integer('total_harga')->nullable()->after('total_tamu');
        });
    }

    public function down(): void
    {
        Schema::table('reservasi', function (Blueprint $table) {
            $table->dropColumn('total_harga');
        });
    }
};