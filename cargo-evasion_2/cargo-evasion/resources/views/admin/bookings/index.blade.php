@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-32">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-black uppercase italic tracking-tighter">Gestion des <span class="text-emerald-500">Réservations</span></h1>
        <div class="bg-black text-white px-4 py-2 rounded-full text-xs font-bold">
            {{ $bookings->total() }} RÉSERVATIONS
        </div>
    </div>
        <div class="mb-10 bg-white border-2 border-black rounded-[32px] p-6 shadow-xl">
            <form action="{{ route('admin.bookings.index') }}" method="GET" class="flex flex-wrap items-end gap-6">
                
                <div class="flex-1 min-w-[300px]">
                    <label class="block text-[10px] font-black uppercase text-gray-400 mb-2 ml-1">Rechercher un client ou une réf.</label>
                    <div class="flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Ex: Dupont ou MILLY-..." 
                            class="flex-1 px-4 py-3 border-2 border-gray-100 rounded-2xl text-sm font-bold focus:border-emerald-500 focus:bg-gray-50 outline-none transition-all">
                        
                        <button type="submit" class="bg-black text-white px-6 py-3 rounded-2xl font-black uppercase italic text-xs hover:bg-emerald-500 transition-all shadow-[4px_4px_0px_0px_rgba(16,185,129,1)] flex items-center gap-2">
                            <span>🔍</span>
                            <span>Rechercher</span>
                        </button>
                    </div>
                </div>

                <div class="w-64">
                    <label class="block text-[10px] font-black uppercase text-gray-400 mb-2 ml-1">Filtrer par état</label>
                    <select name="status" onchange="this.form.submit()" class="w-full p-3 border-2 border-gray-100 rounded-2xl text-sm font-bold outline-none bg-white focus:border-emerald-500 transition-all cursor-pointer">
                        <option value="">Tous les statuts</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>✅ Confirmé</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ En attente</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>❌ Annulé</option>
                    </select>
                </div>

                @if(request()->filled('search') || request()->filled('status'))
                    <div class="pb-3">
                        <a href="{{ route('admin.bookings.index') }}" class="text-[10px] font-black text-gray-400 hover:text-red-500 uppercase tracking-widest transition-colors flex items-center gap-1">
                            ✕ Effacer
                        </a>
                    </div>
                @endif
            </form>
        </div>

    <div class="bg-white border-2 border-black rounded-3xl overflow-hidden shadow-2xl">
        <table class="w-full text-left">
            <thead class="bg-black text-white uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">Réf</th>
                    <th class="px-6 py-4">Client</th>
                    <th class="px-6 py-4">Vélo</th>
                    <th class="px-6 py-4">Dates</th>
                    <th class="px-6 py-4">Prix</th>
                    <th class="px-6 py-4">Statut</th>
                    <th class="px-6 py-4">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($bookings as $booking)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.bookings.show', $booking) }}" class="font-bold text-emerald-600 hover:text-black transition-colors underline decoration-2 underline-offset-4">
                            {{ $booking->reference }}
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold">{{ $booking->user->name }}</div>
                        <div class="text-xs text-gray-500">{{ $booking->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 font-medium">{{ $booking->bike->model }}</td>
                    <td class="px-6 py-4 text-sm">
                        du {{ \Carbon\Carbon::parse($booking->start_date)->format('d/m H:i') }}<br>
                        au {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m H:i') }}
                    </td>
                    <td class="px-6 py-4 font-black">{{ $booking->total_price }} €</td>
                    <td class="px-6 py-4">
                        @php
                            $colors = [
                                'confirmed' => 'bg-emerald-100 text-emerald-700',
                                'pending'   => 'bg-amber-100 text-amber-700',
                                'cancelled' => 'bg-red-100 text-red-700'
                            ];
                            $color = $colors[$booking->status] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <span class="{{ $color }} px-3 py-1 rounded-full text-[10px] font-black uppercase">
                            {{ $booking->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="text-xs border-gray-200 rounded-lg p-1">
                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Attente</option>
                                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmé</option>
                                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        {{ $bookings->links() }}
    </div>
</div>
@endsection