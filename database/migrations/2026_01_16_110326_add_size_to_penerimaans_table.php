<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('penerimaans', function (Blueprint $table) {
        // Tambahin kolom size setelah produk_id
        $table->string('size')->after('produk_id')->nullable();
    });
}

public function down()
{
    Schema::table('penerimaans', function (Blueprint $table) {
        $table->dropColumn('size');
    });
}
};
