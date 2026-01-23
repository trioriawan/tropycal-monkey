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
            // Kita tambah dua kolom ini setelah kolom ID atau sesuai kebutuhan
            $table->string('no_penerimaan')->nullable()->after('id');
            $table->string('distributor')->nullable()->after('no_penerimaan');
        });
    }
    
    public function down(): void
    {
        Schema::table('penerimaans', function (Blueprint $table) {
            $table->dropColumn(['no_penerimaan', 'distributor']);
        });
    }
};
