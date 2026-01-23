<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\ProdukSize;
use App\Models\Penerimaan; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    /**
     * Tampilkan halaman produk
     * Menghilangkan error "Call to undefined method ProdukController::index()"
     */
    public function index()
    {
        $produks = Produk::with('sizes')->orderBy('created_at', 'desc')->get();
        return view('produk', compact('produks'));
    }

    /**
     * Simpan Produk Baru dan Stok Awal
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Simpan Header Produk
            $produk = Produk::create([
                'nama_produk' => $request->nama_produk,
                'harga_beli' => $request->harga_beli ?? 0,
                'harga_jual' => $request->harga_jual ?? 0,
            ]);

            $sizes = [
                'S' => 'stok_s', 
                'M' => 'stok_m', 
                'L' => 'stok_l', 
                'XL' => 'stok_xl',
                'XXL' => 'stok_xxl',
                'ALL SIZE' => 'stok_all'
            ];

            // Nomor transaksi unik untuk history
            $noTrx = 'IN-AWAL-' . strtoupper(uniqid());

            foreach ($sizes as $sizeLabel => $inputName) {
                // Gunakan input() dengan default 0 untuk cegah "Undefined key"
                $qty = $request->input($inputName, 0);

                // Update Stok di Tabel Utama
                ProdukSize::updateOrCreate(
                    ['produk_id' => $produk->id, 'size' => $sizeLabel],
                    ['stok' => $qty]
                );

                // 2. Masukkan ke Laporan Penerimaan jika ada stok awal
                if ($qty > 0) {
                    Penerimaan::create([
                        'produk_id'    => $produk->id,
                        'size'         => $sizeLabel,
                        'qty_masuk'    => $qty,
                        'harga_beli'   => $request->harga_beli ?? 0,
                        'no_penerimaan'=> $noTrx, // DISESUAIKAN: Kolom DB lo 'no_penerimaan'
                        'petugas'      => auth()->user()->name ?? 'Admin',
                    ]);
                }
            }

            DB::commit();
            return back()->with('success', 'Produk dan Stok Berhasil Masuk Laporan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal simpan: ' . $e->getMessage());
        }
    }

    /**
     * Update Produk (Termasuk Penambahan Stok di Laporan)
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $produk = Produk::findOrFail($id);
            $produk->update([
                'nama_produk' => $request->nama_produk,
                'harga_beli' => $request->harga_beli ?? 0,
                'harga_jual' => $request->harga_jual ?? 0,
            ]);

            $sizes = [
                'S' => 'stok_s', 'M' => 'stok_m', 'L' => 'stok_l', 
                'XL' => 'stok_xl', 'XXL' => 'stok_xxl', 'ALL SIZE' => 'stok_all'
            ];

            $noTrx = 'IN-UPDATE-' . strtoupper(uniqid());

            foreach ($sizes as $sizeLabel => $inputName) {
                $newStok = $request->input($inputName, 0);
                
                $oldSizeData = ProdukSize::where('produk_id', $id)->where('size', $sizeLabel)->first();
                $oldStok = $oldSizeData ? $oldSizeData->stok : 0;

                ProdukSize::updateOrCreate(
                    ['produk_id' => $id, 'size' => $sizeLabel],
                    ['stok' => $newStok]
                );

                // Jika ada penambahan stok, catat di penerimaan
                if ($newStok > $oldStok) {
                    Penerimaan::create([
                        'produk_id'    => $id,
                        'size'         => $sizeLabel,
                        'qty_masuk'    => $newStok - $oldStok,
                        'harga_beli'   => $request->harga_beli ?? 0,
                        'no_penerimaan'=> $noTrx,
                        'petugas'      => auth()->user()->name ?? 'Admin',
                    ]);
                }
            }

            DB::commit();
            return back()->with('success', 'Data Berhasil Diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete(); 
        return back()->with('success', 'Produk Berhasil Dihapus!');
    }
}