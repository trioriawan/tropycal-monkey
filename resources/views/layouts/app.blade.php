<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tropical Monkey - POS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        .sidebar-transition { transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    </style>
</head>
<body class="bg-[#F4F7F6] overflow-hidden" x-data="{ open: false }">

    <div class="flex h-screen w-full">
        <aside 
            class="sidebar-transition bg-[#0B3D0B] text-white flex flex-col shrink-0 z-50 overflow-hidden"
            :class="open ? 'w-64' : 'w-20'">
            
            <div class="h-16 flex items-center px-6 bg-[#082F08] shrink-0">
                <span class="font-bold text-xl" x-show="!open">TM</span>
                <span class="font-bold text-lg whitespace-nowrap ml-2" x-show="open" x-cloak>Tropical Monkey</span>
            </div>

            <nav class="flex-1 mt-4 px-3 space-y-2 overflow-y-auto">
    
    <a href="/dashboard" class="flex items-center p-3 hover:bg-white/10 rounded-xl group transition-all {{ Request::is('dashboard*') ? 'bg-white/10 text-white' : 'text-gray-300' }}">
        <svg class="w-8 h-8 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
        <span class="ml-4 font-medium whitespace-nowrap" x-show="open" x-cloak>Dashboard</span>
    </a>

    <a href="{{ route('users.index') }}" class="flex items-center p-3 hover:bg-white/10 rounded-xl group transition-all {{ Request::is('users*') ? 'bg-white/10 text-white' : 'text-gray-300' }}">
        <svg class="w-8 h-8 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        <span class="ml-4 font-medium whitespace-nowrap" x-show="open" x-cloak>Data User</span>
    </a>

    <a href="/produk" class="flex items-center p-3 hover:bg-white/10 rounded-xl group transition-all {{ Request::is('produk*') ? 'bg-white/10 text-white' : 'text-gray-300' }}">
        <svg class="w-8 h-8 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        <span class="ml-4 font-medium whitespace-nowrap" x-show="open" x-cloak>Data Produk</span>
    </a>

    <a href="{{ route('penerimaan.index') }}" class="flex items-center p-3 hover:bg-white/10 rounded-xl group transition-all {{ Request::is('penerimaan*') ? 'bg-white/10 text-white' : 'text-gray-300' }}">
        <svg class="w-8 h-8 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        <span class="ml-4 font-medium whitespace-nowrap" x-show="open" x-cloak>Penerimaan Barang</span>
    </a>

    <a href="{{ route('pengeluaran.index') }}" class="flex items-center p-3 hover:bg-white/10 rounded-xl group transition-all {{ Request::is('pengeluaran*') ? 'bg-white/10 text-white' : 'text-gray-300' }}">
        <svg class="w-8 h-8 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
        <span class="ml-4 font-medium whitespace-nowrap" x-show="open" x-cloak>Pengeluaran Barang</span>
    </a>

    <a href="{{ route('laporan.index') }}" class="flex items-center p-3 hover:bg-white/10 rounded-xl group transition-all {{ Request::is('laporan*') ? 'bg-white/10 text-white' : 'text-gray-300' }}">
        <svg class="w-8 h-8 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <span class="ml-4 font-medium whitespace-nowrap" x-show="open" x-cloak>Laporan Riwayat</span>
    </a>

</nav>
        </aside>

        <div class="flex-1 flex flex-col min-w-0">
            <header class="h-16 bg-white border-b flex items-center justify-between px-8 shrink-0">
    <div class="flex items-center gap-4">
        <button @click="open = !open" class="p-2 hover:bg-gray-100 rounded-lg cursor-pointer text-[#0B3D0B]">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <span class="text-gray-400 font-medium uppercase tracking-widest text-sm">Home</span>
    </div>

    <div class="flex items-center gap-3">
        <span class="font-bold text-gray-700">ADMIN</span>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            
            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin keluar?');" class="block focus:outline-none" title="Klik untuk Logout">
                
                <div class="w-9 h-9 bg-gray-200 rounded-full border border-gray-300 hover:bg-red-500 hover:border-red-600 transition-colors duration-200 cursor-pointer flex items-center justify-center group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </div>

            </button>
        </form>
        </div>
</header>
            <main class="flex-1 overflow-auto p-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>