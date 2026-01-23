<?php

namespace App\Http\Controllers;

use App\Models\Penerimaan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\LaporanExport; 
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    // --- FUNGSI UNTUK TAMPILAN WEB (HALAMAN LAPORAN) ---
    public function index(Request $request)
    {
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));

        $pengeluarans = Pengeluaran::select(
                'no_transaksi', 
                DB::raw('MAX(created_at) as created_at'),
                DB::raw('SUM(qty_keluar) as total_qty'),
                DB::raw('SUM(qty_keluar * harga_jual_saat_ini) as total_bayar')
            )
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->groupBy('no_transaksi')
            ->orderBy('created_at', 'desc')
            ->get();

        $penerimaans = Penerimaan::select(
                'no_penerimaan as no_transaksi', 
                DB::raw('MAX(created_at) as created_at'),
                DB::raw('SUM(qty_masuk) as total_qty'),
                DB::raw('SUM(qty_masuk * harga_beli) as total_bayar')
            )
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->groupBy('no_penerimaan', 'created_at') 
            ->orderBy('created_at', 'desc')
            ->get();

        $omzet = $pengeluarans->sum('total_bayar');
        $totalKeluar = $pengeluarans->sum('total_qty');
        $totalMasuk = $penerimaans->sum('total_qty');

        return view('laporan.index', compact(
            'penerimaans', 'pengeluarans', 'omzet', 'totalKeluar', 'totalMasuk', 'bulan', 'tahun'
        ));
    }

    // --- FUNGSI KHUSUS DOWNLOAD EXCEL ---
    public function exportExcel(Request $request)
    {
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));
        $nama_file = 'Laporan_Tropical_Monkey_'.$bulan.'_'.$tahun.'.xlsx';
    
        return Excel::download(new LaporanExport($bulan, $tahun), $nama_file);
    }

    // --- FUNGSI DETAIL MODAL ---
    public function show($no_transaksi)
    {
        $detail = Pengeluaran::with('produk')->where('no_transaksi', $no_transaksi)->get();
        if($detail->isEmpty()) {
            $detail = Penerimaan::with('produk')->where('no_penerimaan', $no_transaksi)->get();
        }
        return response()->json($detail);
    }

    // --- FUNGSI PRINT ---
    public function printNota($no_transaksi) 
    {
        $detail = Pengeluaran::with('produk')->where('no_transaksi', $no_transaksi)->get();
        if($detail->isEmpty()) {
            $detail = Penerimaan::with('produk')->where('no_penerimaan', $no_transaksi)->get();
        }
        return view('laporan.print_nota', compact('detail', 'no_transaksi'));
    }
}