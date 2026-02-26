@extends('layouts.admin')

@section('content')
<div class="mb-10">
    <h2 class="text-4xl font-black italic tracking-tighter uppercase">Dashboard <span class="text-emerald-500">Milly Évasion</span></h2>
    <p class="text-gray-500 font-medium">Voici ce qu'il se passe sur votre plateforme aujourd'hui.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
    <div class="bg-white p-6 rounded-3xl border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
        <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Réservations (24h)</p>
        <p class="text-4xl font-black">{{ $stats['bookings_today'] }}</p>
    </div>
    
    <div class="bg-white p-6 rounded-3xl border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] text-emerald-600">
        <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">C.A Total (Payé)</p>
        <p class="text-4xl font-black">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} €</p>
    </div>

    <div class="bg-white p-6 rounded-3xl border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
        <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Vélos Libres</p>
        <p class="text-4xl font-black">{{ $stats['available_bikes'] }}</p>
    </div>

    <div class="bg-white p-6 rounded-3xl border-2 border-emerald-500 shadow-[4px_4px_0px_0px_rgba(16,185,129,1)]">
        <p class="text-xs font-black text-emerald-500 uppercase tracking-widest mb-1">Locations en cours</p>
        <p class="text-4xl font-black">{{ $stats['active_rentals'] }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="bg-white rounded-3xl border-2 border-black overflow-hidden">
        <div class="bg-black text-white p-4 font-bold text-sm uppercase">Dernières réservations</div>
        <div class="p-4">
            @foreach($recentBookings as $booking)
                <div class="flex justify-between items-center py-3 border-b border-gray-100 last:border-0">
                    <div>
                        <p class="font-bold">{{ $booking->user->name }}</p>
                        <p class="text-xs text-gray-400">{{ $booking->reference }}</p>
                    </div>
                    <div class="text-right text-sm">
                        <p class="font-black">{{ $booking->total_price }} €</p>
                        <p class="text-[10px] uppercase font-bold text-emerald-500">{{ $booking->status }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection