@extends('layouts.front')

@section('title', 'Finaliser ma réservation — Milly Évasion')

@section('content')
<div class="pt-40 pb-32 bg-[#FBFBFB] min-h-screen">
    <div class="max-w-5xl mx-auto px-6 grid md:grid-cols-12 gap-16">
        
        <div class="md:col-span-7">
            <h1 class="text-5xl font-[900] italic tracking-tighter uppercase mb-2 text-black leading-none">
                Coordonnées<span class="text-emerald-500">.</span>
            </h1>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-12">Ces informations seront utilisées pour votre contrat de location.</p>

            <form action="{{ route('checkout.store') }}" method="POST" class="space-y-8">
                @csrf
                
                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-4">Prénom</label>
                        <input type="text" name="first_name" value="{{ old('first_name', Auth::user()?->first_name) }}" required class="w-full bg-white border-none rounded-[20px] p-4 shadow-sm focus:ring-2 focus:ring-emerald-500 transition">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-4">Nom</label>
                        <input type="text" name="last_name" value="{{ old('last_name', Auth::user()?->last_name) }}" required class="w-full bg-white border-none rounded-[20px] p-4 shadow-sm focus:ring-2 focus:ring-emerald-500 transition">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-4">Numéro de téléphone</label>
                    <input type="tel" name="phone" value="{{ old('phone', Auth::user()?->phone) }}" placeholder="06 .. .. .. .." required class="w-full bg-white border-none rounded-[20px] p-4 shadow-sm focus:ring-2 focus:ring-emerald-500 transition">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-4">Adresse Email</label>
                    <input type="email" name="email" value="{{ old('email', Auth::user()?->email) }}" required class="w-full bg-white border-none rounded-[20px] p-4 shadow-sm focus:ring-2 focus:ring-emerald-500 transition">
                </div>

                @guest
                <div class="p-8 bg-emerald-50 rounded-[32px] border border-emerald-100 space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <p class="text-xs font-black uppercase tracking-widest text-emerald-900">Sécurisez votre compte client</p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-emerald-600 ml-4">Mot de passe</label>
                            <input type="password" name="password" required class="w-full bg-white border-none rounded-[20px] p-4 shadow-sm focus:ring-2 focus:ring-emerald-500 transition">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-emerald-600 ml-4">Confirmation</label>
                            <input type="password" name="password_confirmation" required class="w-full bg-white border-none rounded-[20px] p-4 shadow-sm focus:ring-2 focus:ring-emerald-500 transition">
                        </div>
                    </div>
                </div>
                @endguest

                <div class="pt-8">
                    <button type="submit" class="w-full py-6 bg-black text-white rounded-full font-black uppercase tracking-[0.2em] text-xs hover:bg-emerald-600 transition shadow-2xl shadow-black/10">
                        Confirmer et aller au paiement
                    </button>
                    <p class="text-center text-[10px] text-gray-400 mt-6 px-12">
                        En cliquant, vous acceptez nos CGV et confirmez avoir pris connaissance des conditions de sécurité liées à la forêt de Fontainebleau.
                    </p>
                </div>
            </form>
        </div>

        <div class="md:col-span-5">
            <div class="bg-white rounded-[40px] p-10 shadow-sm sticky top-32 border border-gray-100">
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 mb-8">Résumé de la location</p>
                
                <div class="space-y-6">
                    @foreach($cart as $item)
                    <div class="flex justify-between items-center pb-6 border-b border-gray-50">
                        <div>
                            <p class="font-black uppercase italic text-lg leading-none">{{ $item['model'] }}</p>
                            <p class="text-[10px] text-gray-400 font-bold uppercase mt-1">{{ $item['label'] }}</p>
                        </div>
                        <span class="font-black text-lg">{{ $item['price'] }}€</span>
                    </div>
                    @endforeach
                </div>

                <div class="mt-10 flex justify-between items-end">
                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Total à régler</span>
                    <span class="text-5xl font-[900] tracking-tighter">{{ $total }}€</span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection