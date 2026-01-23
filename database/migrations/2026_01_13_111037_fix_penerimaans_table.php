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
        Schema::table('penerimaans', function (Blueprint $table) {
            // Cek dulu apakah kolom sudah ada sebelum dibuat (biar gak error)
            if (!Schema::hasColumn('penerimaans', 'no_penerimaan')) {
                $table->string('no_penerimaan')->nullable()->after('id');
            }
            if (!Schema::hasColumn('penerimaans', 'distributor')) {
                $table->string('distributor')->nullable()->after('no_penerimaan');
            }
            if (!Schema::hasColumn('penerimaans', 'harga_beli')) {
                $table->integer('harga_beli')->default(0)->after('qty_masuk');
            }
        });
    }
    
    public function down(): void
    {
        Schema::table('penerimaans', function (Blueprint $table) {
            $table->dropColumn(['no_penerimaan', 'distributor', 'harga_beli']);
        });
    }
};
