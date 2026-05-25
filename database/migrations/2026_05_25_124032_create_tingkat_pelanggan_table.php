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
        Schema::create('tingkat_pelanggan', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50);
            $table->integer('poin_minimal')->default(0);
            $table->decimal('persentase_diskon', 5, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tingkat_pelanggan');
    }
};
