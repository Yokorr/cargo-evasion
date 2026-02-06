@extends('layouts.front')

@section('title', 'Votre Sélection — Milly Évasion')

@section('content')
<div class="pt-48 pb-32 bg-white min-h-screen">
    <div class="max-w-4xl mx-auto px-6">
        
        <h1 class="text-6xl font-[900] italic tracking-tighter uppercase mb-12 text-black leading-none">
            Ma Sélection<span class="text-emerald-500">.</span>
        </h1>

        @if(count($cart) > 0)
            <div class="space-y-4">
                @foreach($cart as $item)
                    <div class="flex justify-between items-center p-8 bg-[#FBFBFB] rounded-[32px] border border-gray-100">
                        <div class="flex gap-8 items-center">
                            <div class="w-16 h-16 bg-black rounded-2xl flex items-center justify-center text-white">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-width="2"/></svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black uppercase italic tracking-tighter">{{ $item['model'] }}</h3>
                                <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest mt-1 italic">
                                    Milly-la-Forêt • {{ \Carbon\Carbon::parse($item['start_date'])->format('d/m H:i') }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right flex items-center gap-8">
                            <span class="text-3xl font-black">{{ $item['price'] }}€</span>
                            <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="text-gray-300 hover:text-red-500 transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="3"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

                <div class="pt-16 mt-16 border-t border-gray-100 flex flex-col md:flex-row justify-between items-end gap-8">
                    <div>
                        <p class="text-gray-400 text-[10px] font-black uppercase tracking-[0.4em] mb-2">Total TTC</p>
                        <p class="text-7xl font-black tracking-tighter leading-none">{{ $total }}€</p>
                    </div>
                    
                    <div class="flex gap-4">
                        <a href="{{ route('bikes.index') }}" class="px-10 py-6 rounded-full border-2 border-black text-black font-black uppercase tracking-widest text-[10px] hover:bg-gray-50 transition">
                            Continuer
                        </a>
                        <button class="px-10 py-6 rounded-full bg-emerald-500 text-white font-black uppercase tracking-widest text-[10px] hover:bg-black transition shadow-2xl shadow-emerald-200">
                            Payer ma location
                        </button>
                    </div>
                </div>
            </div>
        @else
            @endif
    </div>
</div>
@endsection