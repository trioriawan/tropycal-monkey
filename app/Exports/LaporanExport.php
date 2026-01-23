<?php

namespace App\Exports;

use App\Models\Pengeluaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $bulan, $tahun;

    public function __construct($bulan, $tahun) {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection() {
        // DISINI KUNCINYA: Jangan pake groupBy, biar detail produk keluar semua
        return Pengeluaran::with('produk')
            ->whereMonth('created_at', $this->bulan)
            ->whereYear('created_at', $this->tahun)
            ->get();
    }

    public function headings(): array {
        return ['Tanggal', 'No Transaksi', 'Nama Produk', 'Size', 'Qty', 'Harga', 'Total'];
    }

    public function map($row): array {
        return [
            $row->created_at->format('d/m/Y'),
            $row->no_transaksi,
            $row->produk->nama_produk ?? 'Produk Dihapus',
            $row->size,
            $row->qty_keluar,
            $row->harga_jual_saat_ini,
            $row->qty_keluar * $row->harga_jual_saat_ini
        ];
    }
}