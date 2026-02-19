<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Milly Évasion — Location de vélos cargos')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-white text-gray-900 font-['Inter',sans-serif]">

    <header class="milly-header">
        <nav class="milly-nav-container">
            <a href="/" class="flex items-center gap-2 group">
                <div class="milly-logo-box">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="flex flex-col leading-none">
                    <span class="milly-logo-text-main">Milly Évasion<span class="text-emerald-500">.</span></span>
                    <span class="milly-logo-text-sub">Milly-la-Forêt</span>
                </div>
            </a>

            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('bikes.index') }}" class="milly-nav-link">La Flotte</a>
                <a href="#" class="milly-nav-link">Le Cyclop</a>
                <a href="#" class="milly-nav-link">Contact</a>
            </div>

            <div class="flex items-center gap-6">
                <a href="{{ route('cart.index') }}" class="relative group p-2">
                    <svg class="w-6 h-6 text-black group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="milly-cart-badge">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>

                @auth
                    <a href="{{ url('/dashboard') }}" class="milly-account-btn">Compte</a>
                @else
                    <a href="{{ route('login') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-black transition">Login</a>
                @endauth
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="milly-footer">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
            <span class="text-sm font-bold opacity-50 text-center">© 2026 Milly Évasion — Location de vélos cargos dans le 91.</span>
            <div class="flex gap-6">
                <a href="#" class="milly-footer-link">Mentions Légales</a>
                <a href="#" class="milly-footer-link">CGV</a>
            </div>
        </div>
    </footer>

</body>
</html>