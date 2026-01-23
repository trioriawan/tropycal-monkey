<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

        protected $fillable = ['produk_id', 'size', 'qty_keluar', 'harga_jual_saat_ini', 'no_transaksi', 'petugas'];
        
    // Tambahin ini biar di laporan gampang manggil nama produknya
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}