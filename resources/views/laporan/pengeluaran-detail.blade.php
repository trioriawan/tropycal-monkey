@extends('layouts.app')

@section('content')
<div class="mb-4 no-print">
    <h1 class="text-[18px] font-bold text-gray-800">Laporan Pengeluaran Barang (Transaksi)</h1>
    <p class="text-[10px] text-gray-400">Home / Laporan / <span class="text-blue-400 font-medium">Laporan Pengeluaran Barang</span></p>
</div>

<div class="bg-white rounded-lg border border-gray-200 p-8 max-w-5xl mx-auto shadow-sm">
    <h2 class="text-[12px] font-bold text-gray-700 mb-5">Laporan Pengeluaran Barang (Transaksi) #TRX-00011457</h2>

    <div class="border-t border-x border-gray-200 p-4 space-y-1">
        <div class="grid grid-cols-12 text-[10px] text-gray-500">
            <span class="col-span-2 font-bold uppercase">Tanggal</span>
            <span class="col-span-10">: Senin, 05 Januari 2026</span>
        </div>
        <div class="grid grid-cols-12 text-[10px] text-gray-500">
            <span class="col-span-2 font-bold uppercase">Nama Petugas</span>
            <span class="col-span-10">: Admin</span>
        </div>
        <div class="grid grid-cols-12 text-[10px] text-gray-500">
            <span class="col-span-2 font-bold uppercase">Jumlah Bayar</span>
            <span class="col-span-10">: 400.000</span>
        </div>
        <div class="grid grid-cols-12 text-[10px] text-gray-500">
            <span class="col-span-2 font-bold uppercase">Kembalian</span>
            <span class="col-span-10">: 1.000</span>
        </div>
        <div class="grid grid-cols-12 text-[10px] text-gray-500">
            <span class="col-span-2 font-bold uppercase">Total Harga</span>
            <span class="col-span-10">: 399.000</span>
        </div>
    </div>

    <div class="border border-gray-200 mt-4 overflow-hidden rounded">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-200 text-[10px] font-bold text-gray-600 uppercase">
                    <th class="p-2 border-r border-gray-200 w-12 text-center">No</th>
                    <th class="p-2 border-r border-gray-200">Nama Produk</th>
                    <th class="p-2 border-r border-gray-200 text-center w-24">Qty</th>
                    <th class="p-2 border-r border-gray-200 text-center w-32">Harga</th>
                    <th class="p-2 text-center w-32 uppercase">Total</th>
                </tr>
            </thead>
            <tbody class="text-[10px] text-gray-500">
                <tr class="border-b border-gray-200">
                    <td class="p-2 border-r border-gray-200 text-center">1</td>
                    <td class="p-2 border-r border-gray-200 italic">Tshirt VonDutch Ubud</td>
                    <td class="p-2 border-r border-gray-200 text-center">1</td>
                    <td class="p-2 border-r border-gray-200 text-center">Rp.399.000</td>
                    <td class="p-2 text-center text-gray-400">Rp.399.000</td>
                </tr>
                <tr class="font-bold text-gray-700">
                    <td colspan="4" class="p-2 text-right border-r border-gray-200 uppercase tracking-tighter">Total Harga</td>
                    <td class="p-2 text-center text-gray-700">Rp.399.000</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6 flex justify-center no-print">
    <button onclick="window.print()" class="bg-[#5CB85C] text-white px-6 py-2 rounded font-bold text-[11px] shadow-sm hover:bg-green-600 transition">
        PRINT LAPORAN
    </button>
</div>
@endsection