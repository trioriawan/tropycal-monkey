<?php

namespace App\Imports;

use App\Models\Produk;
use App\Models\ProdukSize;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProdukImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // 1. Simpan Produk utamanya dulu
        $produk = Produk::create([
            'nama_produk' => $row['nama'], // Sesuaikan dengan header Excel lo
            'harga_beli'  => $row['harga_beli'],
            'harga_jual'  => $row['harga_jual'],
        ]);

        // 2. Simpan stok ke tabel ProdukSize
        $sizes = [
            'S'  => $row['stok_s'] ?? 0,
            'M'  => $row['stok_m'] ?? 0,
            'L'  => $row['stok_l'] ?? 0,
            'XL' => $row['stok_xl'] ?? 0,
        ];

        foreach ($sizes as $size => $stok) {
            ProdukSize::create([
                'produk_id' => $produk->id,
                'size'      => $size,
                'stok'      => $stok,
            ]);
        }

        return $produk;
    }
}