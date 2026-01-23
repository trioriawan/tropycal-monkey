@extends('layouts.app')

@section('content')
<div x-data="posSystem()">
    <div class="mb-4">
        <h1 class="text-[18px] font-bold text-gray-800">Pengeluaran Barang / Transaksi</h1>
        <p class="text-[10px] text-gray-400">Home / Dashboard</p>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-5 mb-5 shadow-sm">
        <h2 class="text-[11px] font-bold text-gray-600 mb-4 uppercase">Input Transaksi Baru</h2>
        
        <div class="grid grid-cols-12 gap-3 items-end">
            <div class="col-span-4">
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Produk</label>
                <select x-model="selectedProductId" @change="updateProductDetail()" class="w-full border border-gray-300 rounded px-3 py-1.5 text-[11px] outline-none bg-white">
                    <option value="">Pilih Produk...</option>
                    <template x-for="p in products" :key="p.id">
                        <option :value="p.id" x-text="p.nama_produk"></option>
                    </template>
                </select>
            </div>

            <div class="col-span-2">
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Size</label>
                <select x-model="selectedSize" @change="updateStockBySize()" class="w-full border border-gray-300 rounded px-3 py-1.5 text-[11px] outline-none bg-white" :disabled="!availableSizes.length">
                    <option value="">Pilih Size...</option>
                    <template x-for="s in availableSizes" :key="s.id">
                        <option :value="s.size" x-text="s.size"></option>
                    </template>
                </select>
            </div>

            <div class="col-span-2">
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1 text-center">Stok Tersedia</label>
                <input type="text" :value="currentStock" disabled class="w-full border border-gray-200 rounded px-3 py-1.5 text-[11px] text-center bg-[#F9FAFB] font-bold text-gray-600">
            </div>
            <div class="col-span-2">
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1 text-center">Harga</label>
                <input type="text" :value="formatRupiah(currentPrice)" disabled class="w-full border border-gray-200 rounded px-3 py-1.5 text-[11px] text-center bg-[#F9FAFB] font-bold text-gray-600">
            </div>
            <div class="col-span-1">
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1 text-center">Qty</label>
                <input type="number" x-model="qty" class="w-full border border-gray-300 rounded px-2 py-1.5 text-[11px] text-center outline-none focus:ring-1 focus:ring-green-500">
            </div>
            <div class="col-span-1">
                <button @click="addToCart()" class="w-full bg-[#5CB85C] text-white font-bold py-1.5 rounded text-[11px] hover:bg-green-600 transition shadow-sm uppercase">
                    Tambah
                </button>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-5">
        <div class="flex-1 bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden h-fit">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="p-3 text-[10px] font-bold text-gray-600 border-r border-gray-200">Nama Produk</th>
                        <th class="p-3 text-[10px] font-bold text-gray-600 border-r border-gray-200 text-center w-20">Size</th>
                        <th class="p-3 text-[10px] font-bold text-gray-600 border-r border-gray-200 text-center w-16">Qty</th>
                        <th class="p-3 text-[10px] font-bold text-gray-600 border-r border-gray-200 text-center w-28">Harga</th>
                        <th class="p-3 text-[10px] font-bold text-gray-600 border-r border-gray-200 text-center w-32">Sub Total</th>
                        <th class="p-3 text-[10px] font-bold text-gray-600 text-center w-20">Opsi</th>
                    </tr>
                </thead>
                <tbody class="text-[10px] text-gray-600">
                    <template x-for="(item, index) in cart" :key="index">
                        <tr class="border-b border-gray-100 hover:bg-gray-50/50">
                            <td class="p-3 border-r border-gray-200 uppercase font-medium" x-text="item.name"></td>
                            <td class="p-3 border-r border-gray-200 text-center font-bold text-blue-600" x-text="item.size"></td>
                            <td class="p-3 border-r border-gray-200 text-center font-bold" x-text="item.qty"></td>
                            <td class="p-3 border-r border-gray-200 text-right pr-4" x-text="formatRupiah(item.price)"></td>
                            <td class="p-3 border-r border-gray-200 text-right pr-4 font-bold text-gray-800" x-text="formatRupiah(item.subtotal)"></td>
                            <td class="p-3 text-center">
                                <button @click="removeFromCart(index)" class="text-red-500 font-bold hover:underline uppercase text-[9px]">Hapus</button>
                            </td>
                        </tr>
                    </template>
                    <template x-if="cart.length === 0">
                        <tr>
                            <td colspan="6" class="p-10 text-center text-gray-300 italic text-[11px]">Belum ada produk dipilih</td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <div class="w-full lg:w-80">
            <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm space-y-4">
                <div>
                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Total Belanja</label>
                    <div class="w-full bg-[#F3F4F6] border border-gray-200 rounded px-3 py-2 text-[16px] font-black text-gray-800 h-12 flex items-center justify-end" x-text="formatRupiah(totalPrice)"></div>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Jumlah Bayar (Cash)</label>
                    <input type="number" x-model="payment" class="w-full border border-gray-300 rounded px-3 py-2 text-[16px] font-bold outline-none h-12 text-right focus:ring-2 focus:ring-green-500" placeholder="0">
                </div>
                <div>
                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Kembalian</label>
                    <div class="w-full bg-[#F3F4F6] border border-gray-200 rounded px-3 py-2 text-[16px] font-black text-green-600 h-12 flex items-center justify-end" x-text="formatRupiah(change)"></div>
                </div>
                <button @click="simpanTransaksi()" class="w-full bg-[#5CB85C] text-white font-black py-4 rounded hover:bg-green-700 transition text-[12px] shadow-md uppercase tracking-[0.2em]" :disabled="cart.length === 0">
                    Selesaikan Transaksi
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function posSystem() {
        return {
            products: @json($produks),
            selectedProductId: '',
            selectedSize: '',
            availableSizes: [],
            currentPrice: 0,
            currentStock: 0,
            currentProductName: '',
            qty: 1,
            cart: [],
            payment: 0,

            // Jalankan saat Produk dipilih
            updateProductDetail() {
                const prod = this.products.find(p => p.id == this.selectedProductId);
                if (prod) {
                    this.currentProductName = prod.nama_produk;
                    this.currentPrice = prod.harga_jual;
                    this.availableSizes = prod.sizes; // Ambil array sizes dari produk
                    this.selectedSize = ''; // Reset size
                    this.currentStock = 0; // Reset stok sampai size dipilih
                } else {
                    this.resetInput();
                }
            },

            // Jalankan saat Size dipilih
            updateStockBySize() {
                const sizeData = this.availableSizes.find(s => s.size === this.selectedSize);
                this.currentStock = sizeData ? sizeData.stok : 0;
            },

            addToCart() {
                if (!this.selectedProductId || !this.selectedSize || this.qty < 1) {
                    return alert('Lengkapi Produk, Size & Qty!');
                }
                if (this.qty > this.currentStock) {
                    return alert('Stok ' + this.selectedSize + ' tidak mencukupi!');
                }

                // Cek apakah produk dengan size yang sama sudah ada di keranjang
                const existingIndex = this.cart.findIndex(item => item.id === this.selectedProductId && item.size === this.selectedSize);

                if (existingIndex !== -1) {
                    this.cart[existingIndex].qty += parseInt(this.qty);
                    this.cart[existingIndex].subtotal = this.cart[existingIndex].qty * this.cart[existingIndex].price;
                } else {
                    this.cart.push({
                        id: this.selectedProductId,
                        name: this.currentProductName,
                        size: this.selectedSize,
                        price: this.currentPrice,
                        qty: parseInt(this.qty),
                        subtotal: this.currentPrice * this.qty
                    });
                }

                this.resetInput();
            },

            resetInput() {
                this.selectedProductId = '';
                this.selectedSize = '';
                this.availableSizes = [];
                this.currentPrice = 0;
                this.currentStock = 0;
                this.qty = 1;
            },

            removeFromCart(index) {
                this.cart.splice(index, 1);
            },

            get totalPrice() {
                return this.cart.reduce((sum, item) => sum + item.subtotal, 0);
            },

            get change() {
                return this.payment > 0 ? (this.payment - this.totalPrice) : 0;
            },

            formatRupiah(val) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(val);
            },

            async simpanTransaksi() {
                if (this.cart.length === 0) return alert('Keranjang masih kosong!');
                if (this.payment < this.totalPrice) return alert('Uang bayar kurang!');

                if (!confirm('Simpan transaksi?')) return;

                try {
                    const response = await fetch("{{ route('pengeluaran.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            items: this.cart,
                        })
                    });

                    const res = await response.json();

                    if (response.ok) {
                        alert('Transaksi Berhasil!');
                        window.location.reload();
                    } else {
                        alert('Gagal: ' + res.message);
                    }
                } catch (e) {
                    alert('Gagal koneksi ke server!');
                }
            }
        }
    }
</script>
@endsection