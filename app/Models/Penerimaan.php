<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerimaan extends Model
{
    use HasFactory;

    // WAJIB: Daftarkan semua kolom yang boleh diisi secara massal
    protected $fillable = [
        'no_penerimaan', 
        'distributor',
        'produk_id',
        'size',
        'qty_masuk',
        'harga_beli',
        'petugas'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}