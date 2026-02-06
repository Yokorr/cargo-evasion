<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Milly Évasion — Location de vélos cargos')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style> [x-cloak] { display: none !important; } body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="antialiased bg-white text-gray-900">

    <header class="fixed w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-100">
        <nav class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <a href="/" class="flex items-center gap-2 group">
                <div class="w-10 h-10 bg-black rounded-lg flex items-center justify-center shadow-lg group-hover:bg-emerald-600 transition-colors">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div class="flex flex-col leading-none">
                    <span class="text-xl font-[900] tracking-tighter text-black uppercase italic">Milly Évasion<span class="text-emerald-500">.</span></span>
                    <span class="text-[8px] font-bold text-gray-400 uppercase tracking-[0.3em]">Milly-la-Forêt</span>
                </div>
            </a>

            <div class="hidden md:flex items-center gap-8 text-[11px] font-black uppercase tracking-[0.2em] text-gray-500">
                <a href="{{ route('bikes.index') }}" class="hover:text-black transition">La Flotte</a>
                <a href="#" class="hover:text-black transition">Le Cyclop</a>
                <a href="#" class="hover:text-black transition">Contact</a>
            </div>

            <div class="flex items-center gap-6">
                <a href="{{ route('cart.index') }}" class="relative group p-2">
                    <svg class="w-6 h-6 text-black group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute top-0 right-0 bg-emerald-500 text-white text-[10px] font-black w-5 h-5 flex items-center justify-center rounded-full border-2 border-white">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>

                @auth
                    <a href="{{ url('/dashboard') }}" class="text-[10px] font-black uppercase tracking-widest px-5 py-2.5 bg-gray-100 rounded-full hover:bg-black hover:text-white transition">Compte</a>
                @else
                    <a href="{{ route('login') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-black transition">Login</a>
                @endauth
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="bg-black text-white py-12 px-6">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
            <span class="text-sm font-bold opacity-50 text-center">© 2026 Milly Évasion — Location de vélos cargos dans le 91.</span>
            <div class="flex gap-6 text-[10px] font-black uppercase tracking-widest opacity-50">
                <a href="#" class="hover:opacity-100">Mentions Légales</a>
                <a href="#" class="hover:opacity-100">CGV</a>
            </div>
        </div>
    </footer>

</body>
</html>