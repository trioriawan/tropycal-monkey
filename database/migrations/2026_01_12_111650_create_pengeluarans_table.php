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
    Schema::create('pengeluarans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
        $table->integer('qty_keluar');
        $table->bigInteger('harga_jual_saat_ini'); 
        $table->string('no_transaksi');
        $table->string('petugas')->nullable(); // <-- Tambahin ini Bosku!
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluarans');
    }
};
