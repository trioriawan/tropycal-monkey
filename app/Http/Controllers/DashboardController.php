<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Produk;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data Ringkasan (KOTAK HIJAU) - TETAP
        $totalUser = User::count();
        $totalProduk = Produk::count();
        $barangTerjual = Pengeluaran::sum('qty_keluar') ?? 0;
        $totalPendapatan = Pengeluaran::selectRaw('SUM(qty_keluar * harga_jual_saat_ini) as total')
                            ->first()->total ?? 0;

        // 2. Transaksi Terakhir (TABEL KIRI) - TETAP
        $transaksiTerakhir = Pengeluaran::select(
                'no_transaksi',
                DB::raw('MAX(created_at) as created_at'),
                DB::raw('SUM(qty_keluar) as total_item'),
                DB::raw('SUM(qty_keluar * harga_jual_saat_ini) as total_harga')
            )
            ->groupBy('no_transaksi')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 3. Produk Terlaris (TABEL KANAN) - TETAP
        $produkTerlaris = Pengeluaran::select(
                'produk_id',
                'size',
                DB::raw('SUM(qty_keluar) as total_terjual')
            )
            ->with('produk')
            ->groupBy('produk_id', 'size')
            ->orderBy('total_terjual', 'desc')
            ->take(5)
            ->get();

        // --- TAMBAHAN UNTUK CHART UAS (SKOR MAKSIMAL) ---
        // Kita ambil omzet per hari selama 7 hari terakhir
        $salesData = Pengeluaran::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(qty_keluar * harga_jual_saat_ini) as total')
            )
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $labels = $salesData->pluck('date')->map(function($date) {
            return date('d M', strtotime($date));
        });
        $totals = $salesData->pluck('total');
        // --- END TAMBAHAN ---

        return view('dashboard', compact(
            'totalUser', 
            'totalProduk', 
            'barangTerjual', 
            'totalPendapatan',
            'transaksiTerakhir',
            'produkTerlaris',
            'labels', // Kirim ke view
            'totals'  // Kirim ke view
        ));
    }
}