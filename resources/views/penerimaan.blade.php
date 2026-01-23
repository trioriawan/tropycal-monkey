@extends('layouts.app')

@section('content')
<div x-data="penerimaanSystem()" x-init="init()">
    <div class="mb-6 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 text-[18px]">Penerimaan Barang</h1>
            <p class="text-[11px] text-gray-400 mt-1">Inventory / <span class="text-blue-400">Masuk Barang</span></p>
        </div>
        <button @click="simpanSemua()" 
                class="bg-[#4ADE80] text-white px-6 py-2 rounded-lg text-[12px] font-bold shadow-md hover:bg-[#22C55E] transition-all uppercase tracking-wider"
                x-show="listBarang.length > 0">
            Simpan Penerimaan Barang
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-[12px] font-bold text-gray-600 mb-6 border-b pb-2 uppercase">Identitas & Produk</h2>
        
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Distributor</label>
                <input type="text" x-model="distributor" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-[12px] outline-none focus:ring-1 focus:ring-green-500" placeholder="Nama Supplier...">
            </div>
            <div>
            <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Nomor Penerimaan</label>
            <div class="w-full border border-gray-100 bg-gray-50 rounded-lg px-3 py-2 text-[12px] font-mono font-bold text-blue-600">
            OTOMATIS (NP-...)
            </div>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-3 items-end mb-8 bg-gray-50 p-4 rounded-xl border border-dashed border-gray-200">
            <div class="col-span-4">
                <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Produk</label>
                <select x-model="selectedProductId" @change="updateDetail()" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-[12px] outline-none bg-white font-bold uppercase">
                    <option value="">Pilih Produk...</option>
                    <template x-for="p in products" :key="p.id">
                        <option :value="p.id" x-text="p.nama_produk"></option>
                    </template>
                </select>
            </div>
            
            <div class="col-span-2">
                <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Size</label>
                <select x-model="selectedSize" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-[12px] outline-none bg-white font-bold">
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                    <option value="XXL">XXL</option>
                    <option value="ALL SIZE">ALL SIZE</option>
                </select>
            </div>

            <div class="col-span-1">
                <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1 text-center">Qty</label>
                <input type="number" x-model="qty" class="w-full border border-gray-200 rounded-lg px-2 py-2 text-[12px] text-center outline-none bg-white font-bold">
            </div>

            <div class="col-span-2">
                <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1 text-right px-2">Harga Beli</label>
                <input type="number" x-model="hargaBeli" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-[12px] outline-none bg-white text-right">
            </div>

            <div class="col-span-3">
                <button @click="tambahKeTabel()" class="w-full bg-[#0B3D0B] text-white font-bold py-2 rounded-lg hover:bg-black transition shadow-sm text-[12px] uppercase">
                    + Tambahkan
                </button>
            </div>
        </div>

        <div class="overflow-x-auto border border-gray-200 rounded-lg">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-[10px] font-bold text-gray-500 uppercase border-b border-r">Nama Produk</th>
                        <th class="p-3 text-[10px] font-bold text-gray-500 uppercase border-b border-r text-center">Size</th>
                        <th class="p-3 text-[10px] font-bold text-gray-500 uppercase border-b border-r text-center">Qty</th>
                        <th class="p-3 text-[10px] font-bold text-gray-500 uppercase border-b border-r text-right">Sub Total</th>
                        <th class="p-3 text-[10px] font-bold text-gray-500 uppercase border-b text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 italic">
                    <template x-for="(item, index) in listBarang" :key="index">
                        <tr class="hover:bg-gray-50/50">
                            <td class="p-3 text-[11px] font-medium text-gray-700 border-r uppercase" x-text="item.name"></td>
                            <td class="p-3 text-[11px] text-center border-r font-bold text-blue-600" x-text="item.size"></td>
                            <td class="p-3 text-[11px] text-center font-bold text-green-600 border-r" x-text="item.qty"></td>
                            <td class="p-3 text-[11px] text-right font-bold text-gray-800 border-r" x-text="formatRupiah(item.subtotal)"></td>
                            <td class="p-3 text-center">
                                <button @click="hapusBaris(index)" class="text-red-500 hover:underline text-[10px] font-bold uppercase">Batal</button>
                            </td>
                        </tr>
                    </template>
                    <template x-if="listBarang.length === 0">
                        <tr>
                            <td colspan="5" class="p-10 text-center text-gray-300 text-[11px]">Belum ada barang yang ditambahkan ke daftar.</td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function penerimaanSystem() {
        return {
            distributor: '',
            noPenerimaan: '', // Akan diisi via init()
            products: @json($produks), 
            selectedProductId: '',
            selectedSize: 'S',
            qty: 0,
            hargaBeli: 0,
            listBarang: [],
            currentProduct: { name: '', stock: 0 },

            // Fungsi inisialisasi nomor otomatis
            init() {
                this.noPenerimaan = 'NP-{{ date("Ymd-His") }}';
            },

            updateDetail() {
                const prod = this.products.find(p => p.id == this.selectedProductId);
                if(prod) {
                    this.currentProduct = { name: prod.nama_produk };
                    this.hargaBeli = prod.harga_beli;
                } else {
                    this.currentProduct = { name: '', stock: 0 };
                    this.hargaBeli = 0;
                }
            },

            tambahKeTabel() {
                if (!this.selectedProductId || this.qty <= 0) {
                    return alert('Pilih produk dan tentukan Qty yang valid!');
                }
                
                this.listBarang.push({
                    produk_id: this.selectedProductId,
                    name: this.currentProduct.name,
                    size: this.selectedSize,
                    qty: parseInt(this.qty),
                    // Kunci Sukses 1: Nama property HARUS harga_beli (pake underscore)
                    harga_beli: parseInt(this.hargaBeli), 
                    subtotal: parseInt(this.qty) * parseInt(this.hargaBeli)
                });

                // Reset setelah tambah
                this.selectedProductId = '';
                this.qty = 0;
                this.currentProduct = { name: '', stock: 0 };
            },

            hapusBaris(index) {
                this.listBarang.splice(index, 1);
            },

           async simpanSemua() {
    if (!this.distributor) {
        return alert('Isi Nama Distributor dulu, Bos!');
    }

    try {
        const response = await fetch("{{ route('penerimaan.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                distributor: this.distributor,
                // Tidak perlu kirim no_penerimaan dari sini lagi
                items: this.listBarang
            })
        });
        // ... sisa code alert success ...
                    const result = await response.json();

                    if (response.ok) {
                        alert('✅ ' + result.message);
                        window.location.reload(); 
                    } else {
                        alert('❌ Gagal: ' + (result.message || 'Cek koneksi/database'));
                    }
                } catch (error) {
                    console.error(error);
                    alert('❌ Gagal koneksi ke server!');
                }
            },

            formatRupiah(val) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(val);
            }
        }
    }
</script>
@endsection