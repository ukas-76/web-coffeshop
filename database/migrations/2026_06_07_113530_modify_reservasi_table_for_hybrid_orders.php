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
        Schema::table('reservasi', function (Blueprint $table) {
            // 1. Tambahkan kolom penanda jenis transaksi & data pengiriman online
            $table->enum('jenis_pesanan', ['dine_in', 'delivery', 'pickup'])->default('dine_in')->after('pengguna_id');
            $table->text('alamat_pengiriman')->nullable()->after('total_tamu');
            $table->decimal('ongkir', 10, 2)->default(0)->after('alamat_pengiriman');

            // 2. Melonggarkan kolom reservasi lama menjadi nullable (boleh kosong)
            // Kolom-kolom ini akan dikosongkan jika jenis pesanan adalah delivery atau pickup
            $table->unsignedBigInteger('meja_id')->nullable()->change();
            $table->date('tanggal_reservasi')->nullable()->change();
            $table->time('jam_mulai')->nullable()->change();
            $table->time('jam_selesai')->nullable()->change();
            $table->integer('total_tamu')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservasi', function (Blueprint $table) {
            // 1. Kembalikan kolom ke aturan semula (wajib diisi / NOT NULL)
            $table->unsignedBigInteger('meja_id')->nullable(false)->change();
            $table->date('tanggal_reservasi')->nullable(false)->change();
            $table->time('jam_mulai')->nullable(false)->change();
            $table->time('jam_selesai')->nullable(false)->change();
            $table->integer('total_tamu')->nullable(false)->change();

            // 2. Hapus kolom tambahan
            $table->dropColumn(['jenis_pesanan', 'alamat_pengiriman', 'ongkir']);
        });
    }
};