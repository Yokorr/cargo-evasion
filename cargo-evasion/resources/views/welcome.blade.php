<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cargo Évasion - Location de vélos cargos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .rounded-figma { border-radius: 24px; }
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-900">

    <header class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <nav class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-emerald-600 rounded-lg flex items-center justify-center shadow-lg shadow-emerald-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <span class="text-xl font-extrabold tracking-tight text-emerald-900">CARGO ÉVASION</span>
            </div>

            <div class="hidden md:flex items-center gap-8 font-medium text-gray-600">
                <a href="#" class="hover:text-emerald-600 transition">Nos Vélos</a>
                <a href="#" class="hover:text-emerald-600 transition">Tarifs</a>
                <a href="#" class="hover:text-emerald-600 transition">Contact</a>
            </div>

            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-semibold rounded-figma shadow-xl shadow-emerald-200 hover:bg-emerald-700 transition">Mon Espace</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 font-semibold hover:text-emerald-600">Connexion</a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 bg-emerald-900 text-white font-semibold rounded-figma shadow-xl shadow-gray-200 hover:bg-black transition">S'inscrire</a>
                    @endauth
                @endif
            </div>
        </nav>
    </header>

    <section class="pt-32 pb-20 px-6">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-center">
            <div class="space-y-8">
                <h1 class="text-5xl md:text-7xl font-extrabold text-gray-900 leading-[1.1]">
                    Libérez votre mobilité avec <span class="text-emerald-600">Sports Carbone</span>.
                </h1>
                <p class="text-xl text-gray-600 leading-relaxed max-w-lg">
                    Louez un vélo cargo en quelques clics. Simple, écologique et parfait pour vos trajets en famille.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-emerald-600 text-white text-lg font-bold rounded-figma shadow-2xl shadow-emerald-200 hover:scale-105 transition transform text-center">
                        Réserver un vélo
                    </a>
                    <a href="#vélos" class="px-8 py-4 bg-white text-gray-900 text-lg font-bold rounded-figma shadow-sm border border-gray-100 hover:bg-gray-50 transition text-center">
                        Voir la flotte
                    </a>
                </div>
            </div>

            <div class="relative">
                <div class="absolute -top-10 -right-10 w-64 h-64 bg-emerald-100 rounded-full blur-3xl opacity-50"></div>
                <div class="relative bg-emerald-800 h-[500px] rounded-figma shadow-2xl overflow-hidden border-8 border-white">
                    <img src="https://images.unsplash.com/photo-1616422285623-13ff0167c95c?q=80&w=1000&auto=format&fit=crop" 
                         alt="Vélo Cargo" 
                         class="w-full h-full object-cover opacity-80">
                    <div class="absolute bottom-6 left-6 bg-white p-4 rounded-2xl shadow-xl flex items-center gap-4 animate-bounce">
                        <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                            <span class="text-2xl">🚲</span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase">Disponibles</p>
                            <p class="text-lg font-black text-emerald-900">{{ $availableBikesCount }} {{ Str::plural('Vélo', $availableBikesCount) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
</html>