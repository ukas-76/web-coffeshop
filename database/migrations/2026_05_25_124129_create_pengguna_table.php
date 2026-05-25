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
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tingkat_pelanggan_id')->nullable()->constrained('tingkat_pelanggan')->nullOnDelete();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nomor_telepon', 20)->nullable();
            $table->enum('role', ['admin', 'pelanggan'])->default('pelanggan');
            $table->integer('poin')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};
