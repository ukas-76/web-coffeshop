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
        Schema::table('pembayaran', function (Blueprint $table) {
            // Menambahkan kolom id_transaksi setelah kolom id, bertipe string, dan bersifat unik
            $table->string('id_transaksi', 50)->unique()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            // Menghapus kembali kolom jika migration di-rollback
            $table->dropColumn('id_transaksi');
        });
    }
};