<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\ProdukSize;
use App\Models\Penerimaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenerimaanController extends Controller
{
    public function index()
    {
        $produks = Produk::with('sizes')->get();
        $riwayat = Penerimaan::with('produk')->latest()->take(10)->get();
        return view('penerimaan', compact('produks', 'riwayat'));
    }

    public function store(Request $request)
{
    // 1. Definisikan nomor di paling atas
    $nomorFix = 'NP-' . date('Ymd-His');
    $petugas = auth()->user()->name ?? 'Admin';

    try {
        \DB::beginTransaction();

        foreach ($request->items as $item) {
            // Pastikan pakai variabel $nomorFix yang sudah dibuat di atas
            \App\Models\Penerimaan::create([
                'no_penerimaan' => $nomorFix, 
                'distributor'   => $request->distributor,
                'produk_id'     => $item['produk_id'],
                'size'          => $item['size'],
                'qty_masuk'     => $item['qty'],
                'harga_beli'    => $item['harga_beli'],
                'petugas'       => $petugas,
            ]);

            // 2. Update stok di tabel produk_sizes
            \DB::table('produk_sizes')
                ->where('produk_id', $item['produk_id'])
                ->where('size', $item['size'])
                ->increment('stok', $item['qty']);
        }

        \DB::commit();
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil simpan dengan nomor: ' . $nomorFix
        ]);

    } catch (\Exception $e) {
        \DB::rollback();
        return response()->json([
            'status' => 'error',
            'message' => 'Gagal: ' . $e->getMessage()
        ], 500);
    }
}
}