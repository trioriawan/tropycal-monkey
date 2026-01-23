@extends('layouts.app')

@section('content')
<div x-data="{ 
    openModal: false, 
    editOpen: false, 
    openImport: false, 
    editData: {id: '', nama_produk: '', harga_beli: '', harga_jual: '', s: 0, m: 0, l: 0, xl: 0, xxl: 0, all: 0} 
}" class="p-2">
    
    <div class="mb-6 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Produk</h1>
            <p class="text-xs text-gray-400 mt-1">Stok Management / <span class="text-blue-400">Varian Size</span></p>
        </div>
        
        <div class="flex items-center gap-2">
            <button @click="openImport = true" class="bg-blue-500 text-white px-5 py-2 rounded-full text-sm font-bold shadow-sm hover:bg-blue-600 transition-all">
                Import Excel
            </button>
            <button @click="openModal = true" class="bg-green-500 text-white px-5 py-2 rounded-full text-sm font-bold shadow-sm hover:bg-green-600 transition-all">
                + Tambah Produk
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white px-4 py-2 rounded-lg mb-4 text-xs font-bold shadow-md">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr class="text-[11px] font-bold text-gray-400 uppercase">
                    <th class="py-4 px-4">No</th>
                    <th class="py-4 px-4">Nama Barang</th>
                    <th class="py-4 px-4">Harga Jual</th>
                    <th class="py-4 px-4 text-center">Stok (S, M, L, XL, XXL, ALL)</th>
                    <th class="py-4 px-4 text-center">Opsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($produks as $index => $item)
                <tr class="hover:bg-blue-50/30 transition text-[11px] text-gray-600">
                    <td class="py-4 px-4">{{ $index + 1 }}.</td>
                    <td class="py-4 px-4 font-bold uppercase">{{ $item->nama_produk }}</td>
                    <td class="py-4 px-4 font-semibold text-blue-600">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                    <td class="py-4 px-4">
                        <div class="flex flex-wrap justify-center gap-1">
                            @foreach($item->sizes as $s)
                                <span class="bg-white border border-gray-200 px-2 py-0.5 rounded shadow-sm">
                                    <span class="text-gray-400 font-bold text-[9px]">{{ $s->size }}:</span> 
                                    <span class="{{ $s->stok <= 5 ? 'text-red-500' : 'text-green-600' }} font-bold">{{ $s->stok }}</span>
                                </span>
                            @endforeach
                        </div>
                    </td>
                    <td class="py-4 px-4 text-center">
                        <div class="flex justify-center gap-4">
                            <button @click="
                                editData = { 
                                    id: '{{ $item->id }}', 
                                    nama_produk: '{{ $item->nama_produk }}', 
                                    harga_beli: '{{ $item->harga_beli }}', 
                                    harga_jual: '{{ $item->harga_jual }}',
                                    s: '{{ $item->sizes->where('size', 'S')->first()->stok ?? 0 }}',
                                    m: '{{ $item->sizes->where('size', 'M')->first()->stok ?? 0 }}',
                                    l: '{{ $item->sizes->where('size', 'L')->first()->stok ?? 0 }}',
                                    xl: '{{ $item->sizes->where('size', 'XL')->first()->stok ?? 0 }}',
                                    xxl: '{{ $item->sizes->where('size', 'XXL')->first()->stok ?? 0 }}',
                                    all: '{{ $item->sizes->where('size', 'ALL')->first()->stok ?? 0 }}'
                                }; 
                                editOpen = true" 
                                class="text-blue-500 font-bold hover:scale-110 transition">EDIT</button>
                            
                            <form action="{{ route('produk.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 font-bold hover:text-red-600">DELETE</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="py-20 text-center text-gray-400 italic">Belum ada data produk, Bosku.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <template x-if="openModal">
        <div class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div class="bg-white rounded-2xl w-full max-w-lg p-8 shadow-2xl scale-up-center">
                <h3 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4">Tambah Produk Baru</h3>
                <form action="{{ route('produk.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Produk</label>
                            <input type="text" name="nama_produk" class="w-full border-2 border-gray-100 rounded-xl px-4 py-2 text-sm focus:border-blue-500 outline-none transition" required>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Harga Beli</label>
                                <input type="number" name="harga_beli" class="w-full border-2 border-gray-100 rounded-xl px-4 py-2 text-sm outline-none focus:border-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Harga Jual</label>
                                <input type="number" name="harga_jual" class="w-full border-2 border-gray-100 rounded-xl px-4 py-2 text-sm outline-none focus:border-blue-500" required>
                            </div>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                            <p class="text-[10px] font-bold text-gray-400 uppercase mb-3">Stok Awal Per Size</p>
                            <div class="grid grid-cols-4 gap-3 text-center">
                                <div><label class="text-[10px] font-bold">S</label><input type="number" name="stok_s" value="0" class="w-full border rounded-lg p-1.5 text-center text-sm"></div>
                                <div><label class="text-[10px] font-bold">M</label><input type="number" name="stok_m" value="0" class="w-full border rounded-lg p-1.5 text-center text-sm"></div>
                                <div><label class="text-[10px] font-bold">L</label><input type="number" name="stok_l" value="0" class="w-full border rounded-lg p-1.5 text-center text-sm"></div>
                                <div><label class="text-[10px] font-bold">XL</label><input type="number" name="stok_xl" value="0" class="w-full border rounded-lg p-1.5 text-center text-sm"></div>
                                <div><label class="text-[10px] font-bold">XXL</label><input type="number" name="stok_xxl" value="0" class="w-full border rounded-lg p-1.5 text-center text-sm"></div>
                                <div><label class="text-[10px] font-bold">ALL</label><input type="number" name="stok_all" value="0" class="w-full border rounded-lg p-1.5 text-center text-sm"></div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-8">
                        <button type="button" @click="openModal = false" class="text-gray-400 font-bold px-4">Batal</button>
                        <button type="submit" class="bg-blue-600 text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700">Simpan Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </template>

    <template x-if="editOpen">
    <div class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm">
        <div class="bg-white rounded-2xl w-full max-w-lg p-8 shadow-2xl">
            <h3 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4">Update Data & Stok</h3>
            <form :action="'/produk/' + editData.id" method="POST">
                @csrf @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase">Nama Produk</label>
                        <input type="text" name="nama_produk" x-model="editData.nama_produk" class="w-full border-2 border-gray-100 rounded-xl px-4 py-2 text-sm">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="block text-xs font-bold text-gray-500 uppercase">Harga Beli</label><input type="number" name="harga_beli" x-model="editData.harga_beli" class="w-full border-2 border-gray-100 rounded-xl px-4 py-2 text-sm"></div>
                        <div><label class="block text-xs font-bold text-gray-500 uppercase">Harga Jual</label><input type="number" name="harga_jual" x-model="editData.harga_jual" class="w-full border-2 border-gray-100 rounded-xl px-4 py-2 text-sm"></div>
                    </div>
                    <div class="p-4 bg-blue-50 rounded-xl border-2 border-blue-100">
                        <p class="text-[10px] font-bold text-blue-500 uppercase mb-3 text-center">Edit Stok Per Size</p>
                        <div class="grid grid-cols-4 gap-3 text-center">
                            <div><label class="text-[10px] font-bold">S</label><input type="number" name="stok_s" x-model="editData.s" class="w-full border rounded-lg p-1.5 text-center text-sm"></div>
                            <div><label class="text-[10px] font-bold">M</label><input type="number" name="stok_m" x-model="editData.m" class="w-full border rounded-lg p-1.5 text-center text-sm"></div>
                            <div><label class="text-[10px] font-bold">L</label><input type="number" name="stok_l" x-model="editData.l" class="w-full border rounded-lg p-1.5 text-center text-sm"></div>
                            <div><label class="text-[10px] font-bold">XL</label><input type="number" name="stok_xl" x-model="editData.xl" class="w-full border rounded-lg p-1.5 text-center text-sm"></div>
                            <div><label class="text-[10px] font-bold">XXL</label><input type="number" name="stok_xxl" x-model="editData.xxl" class="w-full border rounded-lg p-1.5 text-center text-sm"></div>
                            <div><label class="text-[10px] font-bold">ALL</label><input type="number" name="stok_all" x-model="editData.all" class="w-full border rounded-lg p-1.5 text-center text-sm"></div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-8">
                    <button type="button" @click="editOpen = false" class="text-gray-400 font-bold px-4 hover:text-gray-600">Batal</button>
                    <button type="submit" class="bg-green-600 text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-green-200">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</template>

    <template x-if="openImport">
        <div class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div class="bg-white rounded-2xl w-full max-w-md p-8 shadow-2xl">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-gray-800 uppercase text-sm tracking-widest">Import Data Excel</h3>
                    <button @click="openImport = false" class="text-gray-400 text-2xl hover:text-red-500">&times;</button>
                </div>
                <form action="{{ route('produk.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-400 mb-2 uppercase">File Excel (.xlsx)</label>
                        <input type="file" name="file_excel" class="w-full border-2 border-dashed border-gray-200 rounded-xl p-8 text-center text-xs" required>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-100">
                        🚀 Jalankan Import
                    </button>
                </form>
            </div>
        </div>
    </template>

</div>

<style>
    [x-cloak] { display: none !important; }
    .scale-up-center { animation: scale-up-center 0.2s cubic-bezier(0.390, 0.575, 0.565, 1.000) both; }
    @keyframes scale-up-center { 0% { transform: scale(0.9); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
</style>
@endsection