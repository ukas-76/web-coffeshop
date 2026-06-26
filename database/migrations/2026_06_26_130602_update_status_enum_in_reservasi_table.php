<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Karena MySQL mengubah ENUM bisa kompleks jika menggunakan Schema::table biasa tanpa doctrine/dbal, 
        // kita menggunakan raw statement.
        DB::statement("ALTER TABLE reservasi MODIFY COLUMN status ENUM('menunggu', 'dikonfirmasi', 'diproses', 'ready_diambil', 'sedang_diantar', 'selesai', 'dibatalkan') DEFAULT 'menunggu'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert ke ENUM lama (hati-hati jika ada data dengan status baru, akan error saat rollback. Idealnya data diupdate dulu ke status default).
        DB::statement("UPDATE reservasi SET status = 'menunggu' WHERE status IN ('diproses', 'ready_diambil', 'sedang_diantar')");
        DB::statement("ALTER TABLE reservasi MODIFY COLUMN status ENUM('menunggu', 'dikonfirmasi', 'selesai', 'dibatalkan') DEFAULT 'menunggu'");
    }
};
