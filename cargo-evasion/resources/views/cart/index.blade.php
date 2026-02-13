@extends('layouts.front')

@section('title', 'Votre Sélection — Milly Évasion')

@section('content')
<div class="pt-48 pb-32 bg-white min-h-screen">
    <div class="max-w-4xl mx-auto px-6">
        
        <h1 class="milly-h1 mb-12">
            Ma Sélection<span class="text-emerald-500">.</span>
        </h1>

        @if(count($cart) > 0)
            <div class="space-y-4">
                @foreach($cart as $item)
                    <div class="milly-cart-item">
                        <div class="flex gap-8 items-center">
                            <div class="milly-icon-box">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-width="2"/></svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-black uppercase italic tracking-tighter">{{ $item['model'] }}</h3>
                                <p class="milly-label mt-1">
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
                        <p class="milly-label mb-2">Total TTC</p>
                        <p class="milly-total-price">{{ $total }}€</p>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('bikes.index') }}" class="milly-btn-continue">
                            Continuer
                        </a>
                        <a href="{{ route('checkout.index') }}" class="milly-btn-pay">
                            Payer ma location
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-20">
                <p class="milly-label mb-8">Votre panier est vide</p>
                <a href="{{ route('bikes.index') }}" class="milly-btn-black">Voir la flotte</a>
            </div>
        @endif
    </div>
</div>
@endsection