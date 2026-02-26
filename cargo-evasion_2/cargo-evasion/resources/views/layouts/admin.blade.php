<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Milly Évasion</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-black text-white flex-shrink-0 flex flex-col">
            <div class="p-8">
                <h1 class="text-2xl font-black italic tracking-tighter uppercase">Milly <span class="text-emerald-500">Admin</span></h1>
            </div>

            <nav class="flex-1 px-4 space-y-2">
                <x-admin-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                    📊 Tableau de bord
                </x-admin-nav-link>
                
                <x-admin-nav-link href="{{ route('admin.bookings.index') }}" :active="request()->routeIs('admin.bookings.*')">
                    📅 Réservations
                </x-admin-nav-link>

                <x-admin-nav-link href="{{ route('admin.bikes.index') }}" :active="request()->routeIs('admin.bikes.*')">
                    🚲 La Flotte
                </x-admin-nav-link>

                <x-admin-nav-link href="{{ route('admin.codes.index') }}" :active="request()->routeIs('admin.codes.*')">
                    🔑 Digicodes
                </x-admin-nav-link>
            </nav>

            <div class="p-4 border-t border-gray-800">
                <a href="/" class="block w-full text-center text-xs text-gray-400 hover:text-white mb-4">Voir le site public</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-red-600/20 text-red-500 hover:bg-red-600 hover:text-white py-2 rounded-xl text-xs font-bold transition-all">
                        DÉCONNEXION
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 p-10 overflow-y-auto">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 font-bold rounded-r-lg">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>