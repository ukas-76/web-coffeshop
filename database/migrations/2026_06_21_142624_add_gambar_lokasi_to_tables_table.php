<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('meja', function (Blueprint $table) {
            // Kita buat nullable karena bisa saja awal input gambarnya dikosongkan
            $table->string('gambar_lokasi')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('meja', function (Blueprint $table) {
            $table->dropColumn('gambar_lokasi');
        });
    }
};