@extends('layouts.app')

@section('content')
<div class="mb-6 no-print">
    <h1 class="text-2xl font-bold text-gray-800">Laporan Penerimaan Barang</h1>
    <p class="text-xs text-gray-400 mt-1">Home / Laporan / <span class="text-blue-400">Laporan Penerimaan Barang</span></p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-5xl mx-auto min-h-[600px]">
    <h2 class="text-sm font-bold text-gray-700 mb-6">Laporan Penerimaan Barang</h2>

    <div class="border-t border-x border-gray-200 p-4">
        <div class="grid grid-cols-2 gap-4 text-[11px] text-gray-600">
            <div class="flex">
                <span class="w-24">Tanggal</span>
                <span>: Sabtu, 03 Januari 2026</span>
            </div>
            <div class="flex justify-end">
                </div>
            <div class="flex">
                <span class="w-24">Nama Petugas</span>
                <span>: Admin</span>
            </div>
        </div>
    </div>

    <div class="border-x border-t border-gray-200 p-4 mt-4">
        <p class="text-[11px] font-bold text-gray-700">Nomor Penerimaan : PB-00011457</p>
    </div>

    <div class="border border-gray-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="p-2 text-[11px] font-bold text-gray-700 border-r border-gray-200 w-12 text-center">No</th>
                    <th class="p-2 text-[11px] font-bold text-gray-700 border-r border-gray-200">Nama Produk</th>
                    <th class="p-2 text-[11px] font-bold text-gray-700 border-r border-gray-200 text-center w-24">Qty</th>
                    <th class="p-2 text-[11px] font-bold text-gray-700 border-r border-gray-200 text-center w-32">Harga</th>
                    <th class="p-2 text-[11px] font-bold text-gray-700 text-center w-32">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-[11px] text-gray-600 border-b border-gray-200">
                    <td class="p-2 border-r border-gray-200 text-center">1</td>
                    <td class="p-2 border-r border-gray-200 italic">Tshirt VonDutch Ubud</td>
                    <td class="p-2 border-r border-gray-200 text-center">10</td>
                    <td class="p-2 border-r border-gray-200 text-center">Rp 3.990.000</td>
                    <td class="p-2 text-center">Rp 3.990.000</td>
                </tr>
                <tr class="text-[11px] font-bold text-gray-700 bg-gray-50/50">
                    <td colspan="4" class="p-2 text-right border-r border-gray-200 uppercase">Total Harga</td>
                    <td class="p-2 text-center">Rp 3.990.000</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-12 grid grid-cols-2 text-[11px] text-gray-700">
        <div>
            <p>Petugas</p>
            <div class="mt-16">
                <p>Admin Tropical Monkey</p>
            </div>
        </div>
    </div>
</div>

<div class="fixed bottom-10 right-10 no-print">
    <button onclick="window.print()" class="bg-gray-800 text-white p-4 rounded-full shadow-2xl hover:scale-110 transition-all">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
    </button>
</div>

<style>
    @media print {
        .no-print { display: none !important; }
        body { background: white !important; padding: 0 !important; }
        .shadow-sm { box-shadow: none !important; border: none !important; }
    }
</style>
@endsection