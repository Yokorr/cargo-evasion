@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('admin.bookings.index') }}" class="bg-gray-100 p-2 rounded-full hover:bg-gray-200 transition-all">👈</a>
        <h1 class="text-3xl font-black uppercase italic tracking-tighter">Détail Réservation <span class="text-emerald-500">{{ $booking->reference }}</span></h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="space-y-8">
            <div class="bg-white border-2 border-black rounded-[32px] p-6 shadow-xl">
                <h3 class="text-xs font-black uppercase text-gray-400 mb-4 tracking-widest">👤 Informations Client</h3>
                <p class="text-xl font-black uppercase italic">{{ $booking->user->name }}</p>
                <p class="text-gray-500 font-medium">{{ $booking->user->email }}</p>
                {{-- Ajoute ici le téléphone si tu l'as en base : --}}
                {{-- <p class="mt-2 font-bold">📞 {{ $booking->user->phone ?? 'Non renseigné' }}</p> --}}
            </div>

            <div class="bg-black text-white rounded-[32px] p-6 shadow-xl">
                <h3 class="text-[10px] font-black uppercase text-emerald-500 mb-4 tracking-widest">💰 État du Paiement</h3>
                <div class="flex justify-between items-end">
                    <div>
                        <p class="text-3xl font-black">{{ $booking->total_price }} €</p>
                        <p class="text-xs text-gray-400">Méthode : {{ strtoupper($booking->payment_method) }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-500 text-black">
                        {{ $booking->status }}
                    </span>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white border-2 border-black rounded-[32px] overflow-hidden shadow-xl">
                <div class="p-6 border-b-2 border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h3 class="text-xs font-black uppercase text-gray-400 tracking-widest">🚲 Matériel réservé</h3>
                    <p class="text-xs font-bold text-gray-400">Période : Du {{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }}</p>
                </div>
                
                <div class="p-6">
                    {{-- Ici on affiche le vélo principal, ou une boucle si tu gères plusieurs vélos par résa --}}
                    <div class="flex items-center gap-6">
                        <div class="w-32 h-32 bg-gray-100 rounded-2xl flex items-center justify-center">
                            @if($booking->bike->image)
                                <img src="{{ asset('storage/' . $booking->bike->image) }}" class="w-full h-full object-contain p-2">
                            @endif
                        </div>
                        <div>
                            <h4 class="text-2xl font-black uppercase italic leading-none">{{ $booking->bike->model }}</h4>
                            <p class="text-sm text-gray-400 font-bold mt-1">N° de série : {{ $booking->bike->serial_number }}</p>
                            <div class="mt-4 flex gap-4">
                                <div class="bg-gray-100 px-3 py-1 rounded-lg text-[10px] font-black">START : {{ \Carbon\Carbon::parse($booking->start_date)->format('H:i') }}</div>
                                <div class="bg-gray-100 px-3 py-1 rounded-lg text-[10px] font-black">END : {{ \Carbon\Carbon::parse($booking->end_date)->format('H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection