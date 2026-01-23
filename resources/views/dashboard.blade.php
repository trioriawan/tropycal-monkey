@extends('layouts.app')

@section('content')
<div class="flex justify-between items-end mb-6">
    <h2 class="text-2xl font-bold text-gray-700">Dashboard</h2>
    <nav class="text-sm text-gray-400">Home / <span class="text-blue-500">Dashboard</span></nav>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-[#66E283] p-6 rounded-xl text-white shadow-sm relative overflow-hidden">
        <h3 class="text-4xl font-bold mb-4">{{ $totalUser }}</h3>
        <p class="text-sm font-medium opacity-90 uppercase">Total User</p>
    </div>

    <div class="bg-[#4DBE68] p-6 rounded-xl text-white shadow-sm">
        <h3 class="text-4xl font-bold mb-4">{{ $totalProduk }}</h3>
        <p class="text-sm font-medium opacity-90 uppercase">Total Produk</p>
    </div>

    <div class="bg-[#3A8D4E] p-6 rounded-xl text-white shadow-sm">
        <h3 class="text-4xl font-bold mb-4">{{ number_format($barangTerjual) }}</h3>
        <p class="text-sm font-medium opacity-90 uppercase">Barang Terjual</p>
    </div>

    <div class="bg-[#1B4323] p-6 rounded-xl text-white shadow-sm leading-tight">
        <h3 class="text-2xl font-bold mb-4 mt-2">Rp. {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
        <p class="text-sm font-medium opacity-90 uppercase">Total Pendapatan</p>
    </div>
</div>

<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
    <h4 class="font-bold text-gray-700 uppercase text-[10px] mb-4 text-center">Statistik Penjualan 7 Hari Terakhir</h4>
    <div style="height: 300px;">
        <canvas id="canvasChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('canvasChart').getContext('2d');
        new Chart(ctx, {
            type: 'line', 
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Omzet (Rp)',
                    data: {!! json_encode($totals) !!},
                    borderColor: '#10b981', // Hijau emerald biar match
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { 
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    });
</script>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border p-6">
        <h4 class="font-bold text-gray-700 mb-4 border-b pb-2">Transaksi Terakhir</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-500 uppercase text-[11px] font-bold">
                    <tr>
                        <th class="px-4 py-3">Tanggal Transaksi</th>
                        <th class="px-4 py-3">Nomor Transaksi</th>
                        <th class="px-4 py-3">Jumlah Item</th>
                        <th class="px-4 py-3 text-right">Total Transaksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                   @forelse($transaksiTerakhir as $trx)
    <tr class="hover:bg-gray-50 transition border-b last:border-0">
        <td class="px-4 py-4 text-gray-600 font-medium">{{ $trx->created_at->format('d - m - Y') }}</td>
        <td class="px-4 py-4 text-gray-600">{{ $trx->no_transaksi }}</td>
        <td class="px-4 py-4 text-gray-600">{{ $trx->total_item }} Item</td>
        <td class="py-3 px-4 text-right font-bold">
            {{-- DISINI TADI SALAHNYA, GANTI JADI $trx --}}
            Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
        </td>
    </tr>
@empty
    <tr>
        <td colspan="4" class="px-4 py-10 text-center text-gray-400 italic">Belum ada transaksi.</td>
    </tr>
@endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border p-6">
        <h4 class="font-bold text-gray-700 mb-4 border-b pb-2">Produk Terlaris</h4>
        <table class="w-full text-left text-xs">
    <thead>
        <tr class="text-gray-400 border-b">
            <th class="py-2">NO</th>
            <th class="py-2">NAMA PRODUK</th>
            <th class="py-2 text-center">SIZE</th>
            <th class="py-2 text-right">TERJUAL</th>
        </tr>
    </thead>
    <tbody>
        {{-- Pastikan di sini pake $terlaris (atau apapun) AS $item --}}
        @foreach($produkTerlaris as $index => $item)
        <tr class="border-b last:border-0">
            <td class="py-3">{{ $index + 1 }}</td>
            <td class="py-3 font-bold">
                {{-- Panggil $item di sini --}}
                {{ $item->produk->nama_produk ?? 'Produk Dihapus' }}
            </td>
            <td class="py-3 text-center">
                <span class="bg-gray-100 px-2 py-1 rounded font-bold text-gray-600">
                    {{ $item->size }} {{-- Ini yang nampilin sizenya --}}
                </span>
            </td>
            <td class="py-3 text-right font-bold text-blue-600">
                {{ $item->total_terjual }} PCS
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
    </div>
</div>
@endsection