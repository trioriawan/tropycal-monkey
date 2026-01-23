<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. TABEL PRODUK (INDUK)
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');
            $table->bigInteger('harga_beli');
            $table->bigInteger('harga_jual');
            $table->timestamps();
        });

        // 2. TABEL SIZE (ANAK - TEMPAT STOK ASLI)
        Schema::create('produk_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->string('size'); // S, M, L, XL, dll
            $table->integer('stok')->default(0);
            $table->timestamps();
        });

        // 3. TABEL TRANSAKSI (CATATAN RIWAYAT)
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->string('size'); 
            $table->integer('jumlah');
            $table->enum('tipe', ['masuk', 'keluar']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
        Schema::dropIfExists('produk_sizes');
        Schema::dropIfExists('produks');
    }
};