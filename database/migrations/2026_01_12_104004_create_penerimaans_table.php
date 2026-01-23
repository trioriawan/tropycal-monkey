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
    Schema::create('penerimaans', function (Blueprint $table) {
        $table->id();
        // Pastiin baris ini ada dan tulisannya bener
        $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
        $table->integer('qty_masuk');
        $table->string('petugas');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerimaans');
    }
};
