<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tropical Monkey</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center bg-cover bg-center relative" style="background-image: url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070&auto=format&fit=crop');">
    
    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative bg-white/80 backdrop-blur-md p-8 rounded-xl shadow-2xl w-full max-w-[350px] text-center">
        <h1 class="text-3xl font-light text-gray-500 mb-2">Tropical Monkey</h1>
        
        <div class="h-[1px] bg-gray-300 w-full mb-6"></div>
        
        <p class="text-sm font-bold text-gray-700 mb-6 uppercase tracking-wide">Login untuk memulai</p>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            @if ($errors->any())
                <div class="bg-red-500 text-white text-[10px] p-2 rounded mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="relative">
                <input type="email" name="email" placeholder="email" value="{{ old('email') }}" required
                    class="w-full bg-gray-200/80 border-none rounded py-2.5 px-4 pr-10 focus:ring-2 focus:ring-blue-400 outline-none placeholder-gray-500">
                <div class="absolute right-3 top-3 text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                        <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                    </svg>
                </div>
            </div>

            <div class="relative">
                <input type="password" name="password" placeholder="password" required
                    class="w-full bg-gray-200/80 border-none rounded py-2.5 px-4 pr-10 focus:ring-2 focus:ring-blue-400 outline-none placeholder-gray-500">
                <div class="absolute right-3 top-3 text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3A5.25 5.25 0 0 0 12 1.5Zm-3.75 8.25v-3a3.75 3.75 0 1 1 7.5 0v3H8.25Z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>

            <button type="submit" class="w-full bg-[#3b82f6] hover:bg-blue-600 text-white py-2.5 rounded font-semibold transition shadow-md">
                Login
            </button>
        </form>
    </div>
</body>
</html>