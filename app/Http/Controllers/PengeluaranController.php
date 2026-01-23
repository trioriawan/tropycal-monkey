<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\ProdukSize;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengeluaranController extends Controller
{
    public function index()
    {
        // Ambil produk yang punya minimal 1 size dengan stok > 0
        // with('sizes') supaya di frontend bisa pilih size yang tersedia saja
        $produks = Produk::whereHas('sizes', function($q) {
            $q->where('stok', '>', 0);
        })->with(['sizes' => function($q) {
            $q->where('stok', '>', 0); // Hanya tampilkan size yang masih ada stoknya
        }])->get();

        return view('pengeluaran', compact('produks'));
    }

    public function store(Request $request)
    {
        // Validasi input awal
        if (!$request->has('items') || empty($request->items)) {
            return response()->json(['message' => 'Keranjang belanja masih kosong!'], 422);
        }

        DB::beginTransaction();
        try {
            // --- LOGIKA NOMOR TRANSAKSI (TM-20260116-0001) ---
            // Gue tambahin format tanggal biar nomor urutnya gak tabrakan antar hari
            $today = now()->format('Ymd');
            $lastTransaction = Pengeluaran::where('no_transaksi', 'LIKE', "TM-$today-%")
                                ->orderBy('id', 'desc')
                                ->first();

            if (!$lastTransaction) {
                $nomorUrut = 1;
            } else {
                // Ambil 4 digit terakhir dari no_transaksi
                $lastNumber = explode('-', $lastTransaction->no_transaksi);
                $nomorUrut = ((int) end($lastNumber)) + 1;
            }
            
            $no_transaksi = 'TM-' . $today . '-' . str_pad($nomorUrut, 4, '0', STR_PAD_LEFT);

            foreach ($request->items as $item) {
                // 1. CARI DATA SIZE & STOK
                // Kita kunci barisnya (lockForUpdate) supaya gak ada "Balapan Stok" (Race Condition)
                $variant = ProdukSize::where('produk_id', $item['id'])
                            ->where('size', $item['size'])
                            ->lockForUpdate() 
                            ->first();

                // 2. VALIDASI STOK
                if (!$variant) {
                    throw new \Exception("Varian produk size " . $item['size'] . " tidak ditemukan!");
                }

                if ($variant->stok < $item['qty']) {
                    $namaProduk = Produk::find($item['id'])->nama_produk ?? 'Barang';
                    throw new \Exception("Stok $namaProduk (Size " . $item['size'] . ") tidak cukup! Tersisa: " . $variant->stok);
                }

                // 3. SIMPAN RIWAYAT PENGELUARAN (PENJUALAN)
                Pengeluaran::create([
                    'produk_id' => $item['id'],
                    'size' => $item['size'], // SEKARANG INI SUDAH BISA DISIMPAN
                    'qty_keluar' => $item['qty'],
                    'harga_jual_saat_ini' => $variant->produk->harga_jual,
                    'no_transaksi' => $no_transaksi,
                    'petugas' => auth()->user()->name ?? 'Admin',   
                ]);

                // 4. KURANGI STOK (ID TETAP KONSISTEN)
                // decrement() adalah cara paling aman agar ID tidak berubah
                $variant->decrement('stok', $item['qty']);
            }

            DB::commit();
            return response()->json([
                'status'  => 'success',
                'message' => 'Transaksi Berhasil!',
                'no_transaksi' => $no_transaksi
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}