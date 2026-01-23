@extends('layouts.app')

@section('content')
<div x-data="{ tab: 'pengeluaran' }" class="p-6">
    
    {{-- 1. FORM FILTER (TAMBAHKAN INI) --}}
    <form action="" method="GET" class="mb-6 bg-white p-4 rounded-xl shadow-sm border flex flex-wrap items-end gap-4">
        <div>
            <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Pilih Bulan</label>
            <select name="bulan" class="border rounded-lg px-3 py-2 text-xs font-bold text-gray-700 outline-none">
                @for ($m=1; $m<=12; $m++)
                    <option value="{{ sprintf('%02d', $m) }}" {{ ($bulan ?? date('m')) == sprintf('%02d', $m) ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                    </option>
                @endfor
            </select>
        </div>
        <div>
            <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Pilih Tahun</label>
            <select name="tahun" class="border rounded-lg px-3 py-2 text-xs font-bold text-gray-700 outline-none">
                @for ($y=date('Y')-1; $y<=date('Y')+1; $y++)
                    <option value="{{ $y }}" {{ ($tahun ?? date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg text-xs font-bold transition shadow-md">
            TAMPILKAN
        </button>
        <a href="/laporan" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-6 py-2 rounded-lg text-xs font-bold transition">
            RESET
        </a>
    </form>

    {{-- 2. WIDGET STATISTIK (ANGKA DI SINI OTOMATIS BERUBAH) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-green-100">
            <p class="text-[10px] font-bold text-gray-400 uppercase">Total Omzet Bulan Ini</p>
            <h3 class="text-xl font-bold text-green-600">Rp {{ number_format($omzet, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <p class="text-[10px] font-bold text-gray-400 uppercase">Item Keluar</p>
            <h3 class="text-xl font-bold text-gray-800">{{ number_format($totalKeluar) }} PCS</h3>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <p class="text-[10px] font-bold text-gray-400 uppercase">Item Masuk</p>
            <h3 class="text-xl font-bold text-gray-800">{{ number_format($totalMasuk) }} PCS</h3>
        </div>
    </div>

    {{-- Tab Navigation --}}
    <div class="flex space-x-2 mb-4 bg-gray-100 p-1 rounded-lg w-fit">
        <button @click="tab = 'pengeluaran'" :class="tab === 'pengeluaran' ? 'bg-white shadow-sm text-green-700' : 'text-gray-500'" class="px-4 py-2 rounded-md text-xs font-bold transition-all">
            LAPORAN PENGELUARAN (KASIR)
        </button>
        <button @click="tab = 'penerimaan'" :class="tab === 'penerimaan' ? 'bg-white shadow-sm text-green-700' : 'text-gray-500'" class="px-4 py-2 rounded-md text-xs font-bold transition-all">
            LAPORAN PENERIMAAN (STOK)
        </button>
    </div>

    {{-- Content Tab Pengeluaran --}}
    <div x-show="tab === 'pengeluaran'" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b text-[10px] text-gray-400 uppercase font-bold">
                <tr>
                    <th class="p-4">No Transaksi</th>
                    <th class="p-4 text-center">Total Qty</th>
                    <th class="p-4 text-right">Subtotal</th>
                    <th class="p-4 text-center">Opsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengeluarans as $item)
                <tr class="border-b last:border-0 hover:bg-gray-50 transition">
                    <td class="p-4 font-mono font-bold text-blue-600">{{ $item->no_transaksi }}</td>
                    <td class="p-4 text-center">{{ $item->total_qty }} PCS</td>
                    <td class="p-4 text-right font-bold text-gray-800">Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                    <td class="p-4 text-center">
                        <button type="button" onclick="showDetail('{{ $item->no_transaksi }}')" class="bg-[#1e293b] text-white px-4 py-1.5 rounded text-[10px] font-bold hover:bg-black transition">
                            DETAIL
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Content Tab Penerimaan --}}
    <div x-show="tab === 'penerimaan'" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b text-[10px] text-gray-400 uppercase font-bold">
                <tr>
                    <th class="p-4">No Transaksi</th>
                    <th class="p-4">Tanggal</th>
                    <th class="p-4 text-center">Total Item</th>
                    <th class="p-4 text-center">Opsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penerimaans as $item)
                <tr class="border-b last:border-0 hover:bg-gray-50 transition">
                    <td class="p-4 font-mono font-bold text-green-600">{{ $item->no_transaksi }}</td>
                    <td class="p-4 text-gray-500 text-xs">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                    <td class="p-4 text-center font-bold text-green-600">+{{ $item->total_qty }} PCS</td>
                    <td class="p-4 text-center">
                        <button type="button" onclick="showDetail('{{ $item->no_transaksi }}')" class="bg-[#1e293b] text-white px-4 py-1.5 rounded text-[10px] font-bold hover:bg-black transition">
                            DETAIL
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL DETAIL --}}
<div id="modalDetail" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-[9999] flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl overflow-hidden border">
        <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
            <h2 class="font-bold text-gray-800 text-sm">DETAIL TRANSAKSI: <span id="det_no_transaksi" class="text-blue-600 uppercase"></span></h2>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-2xl font-light">&times;</button>
        </div>

        <div class="p-3 bg-blue-50/50 border-b flex gap-2">
            {{-- Tombol Cetak Nota yang sudah dibenerin --}}
            <button onclick="printNota()" class="bg-[#4DBE68] hover:bg-green-600 text-white px-3 py-1.5 rounded text-[10px] font-bold flex items-center gap-1 shadow-sm transition">
                🖨️ CETAK NOTA
            </button>
            {{-- PDF Browser default --}}
            <button onclick="window.print()" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-[10px] font-bold flex items-center gap-1 shadow-sm transition">
                📄 PDF
            </button>
           <a href="{{ route('laporan.export', ['bulan' => $bulan, 'tahun' => $tahun]) }}" 
            class="bg-emerald-600 text-white px-4 py-2 rounded text-xs font-bold flex items-center gap-2 shadow-sm hover:bg-emerald-700 transition">
            📊 EXPORT EXCEL LENGKAP
            </a>
        </div>

        <div id="printableArea" class="p-0 max-h-[400px] overflow-y-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-gray-100 text-gray-500 uppercase text-[9px] font-bold sticky top-0">
                    <tr>
                        <th class="px-4 py-3">Nama Produk</th>
                        <th class="px-4 py-3 text-center">Size</th>
                        <th class="px-4 py-3 text-center">Qty</th>
                        <th class="px-4 py-3 text-right">Harga</th>
                        <th class="px-4 py-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody id="detailContent">
                </tbody>
            </table>
        </div>

        <div class="p-4 bg-gray-50 border-t flex justify-end gap-2">
            <button onclick="closeModal()" class="bg-gray-200 px-4 py-2 rounded text-gray-700 font-bold text-[10px] uppercase hover:bg-gray-300">Kembali</button>
            <button onclick="closeModal()" class="bg-red-50 px-4 py-2 rounded text-red-600 font-bold text-[10px] uppercase hover:bg-red-100 border border-red-200">Tutup</button>
        </div>
    </div>
</div>

<script>
    let currentTrx = '';

    // FUNGSI TAMPIL DETAIL
    function showDetail(noTrx) {
        currentTrx = noTrx;
        document.getElementById('det_no_transaksi').innerText = noTrx;
        
        const content = document.getElementById('detailContent');
        content.innerHTML = '<tr><td colspan="5" class="text-center py-10 text-gray-400 italic">Mengambil data...</td></tr>';
        
        document.getElementById('modalDetail').classList.remove('hidden');

        fetch(`/laporan/detail/${noTrx}`)
            .then(response => {
                if (!response.ok) throw new Error('Route tidak ditemukan atau Server Error');
                return response.json();
            })
            .then(data => {
                content.innerHTML = '';
                if (data.length === 0) {
                    content.innerHTML = '<tr><td colspan="5" class="text-center py-10">Data tidak ditemukan di database.</td></tr>';
                    return;
                }
                data.forEach(item => {
                    const qty = item.qty_keluar || item.qty_masuk || 0;
                    const harga = item.harga_jual_saat_ini || item.harga_beli || 0;
                    const size = item.size || '-';
                    const namaProduk = item.produk ? item.produk.nama_produk : 'Produk Dihapus';
                    
                    content.innerHTML += `
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-800 font-medium">${namaProduk}</td>
                            <td class="px-4 py-3 text-center font-bold text-blue-600">${size}</td>
                            <td class="px-4 py-3 text-center font-bold">${qty}</td>
                            <td class="px-4 py-3 text-right">Rp ${new Intl.NumberFormat('id-ID').format(harga)}</td>
                            <td class="px-4 py-3 text-right font-bold text-gray-900">Rp ${new Intl.NumberFormat('id-ID').format(qty * harga)}</td>
                        </tr>
                    `;
                });
            })
            .catch(err => {
                console.error(err);
                content.innerHTML = `<tr><td colspan="5" class="text-center py-10 text-red-500">Error: ${err.message}</td></tr>`;
            });
    }

    // FUNGSI TUTUP MODAL
    function closeModal() {
        document.getElementById('modalDetail').classList.add('hidden');
    }

    function exportToExcel() {
    let table = document.querySelector("table"); // Ambil tabel yang lagi tampil
    let html = table.outerHTML;
    window.open('data:application/vnd.ms-excel,' + encodeURIComponent(html));
    }

    // FUNGSI CETAK NOTA (PRINT KHUSUS TABEL)
    function printNota() {
        const printContents = document.getElementById('printableArea').innerHTML;
        const noTrx = document.getElementById('det_no_transaksi').innerText;
        const originalContents = document.body.innerHTML;

        document.body.innerHTML = `
            <div style="padding: 20px; font-family: 'Courier New', Courier, monospace;">
                <center>
                    <h2>TROPICAL MONKEY POS</h2>
                    <p>No Transaksi: ${noTrx}</p>
                    <hr>
                </center>
                ${printContents}
                <hr>
                <center><p>Terima Kasih</p></center>
            </div>
        `;

        window.print();
        document.body.innerHTML = originalContents;
        window.location.reload(); // Wajib reload biar AlpineJS & Modal balik normal
    }
</script>
@endsection