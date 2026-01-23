<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = ['nama_produk', 'harga_beli', 'harga_jual'];

    // Menghubungkan Produk ke banyak Size
    public function sizes()
    {
        return $this->hasMany(ProdukSize::class);
    }
}
