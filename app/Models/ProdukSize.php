<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukSize extends Model
{
    protected $fillable = ['produk_id', 'size', 'stok'];

    // Menghubungkan balik Size ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
