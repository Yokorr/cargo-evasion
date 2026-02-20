@extends('layouts.front')

@section('title', 'Confirmation de réservation — Milly Évasion')

@section('content')
<div class="pt-40 pb-32 bg-[#FBFBFB] min-h-screen flex items-center">
    <div class="max-w-3xl mx-auto px-6 text-center">
        
        <div class="inline-flex items-center justify-center w-20 h-20 bg-emerald-500 rounded-[32px] text-white shadow-xl shadow-emerald-200 mb-10">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <h1 class="milly-h1 text-5xl mb-4">C'est validé<span class="text-emerald-500">.</span></h1>
        <p class="milly-label text-lg mb-12">Référence : <span class="text-black font-black uppercase">{{ $reference }}</span></p>

        <div class="bg-white border-2 border-gray-100 rounded-[48px] p-10 md:p-16 mb-12 shadow-sm text-left">
            @switch($method)
                @case('monetico')
                @case('paypal')
                    <h2 class="font-[900] uppercase italic text-2xl tracking-tighter mb-4">Paiement confirmé</h2>
                    <p class="text-gray-500 leading-relaxed">Votre règlement a bien été reçu. Vous allez recevoir un email récapitulatif avec votre contrat de location. Présentez-vous à notre point de départ à Milly avec une pièce d'identité.</p>
                    @break

                @case('cash')
                    <h2 class="font-[900] uppercase italic text-2xl tracking-tighter mb-4 text-amber-600">Paiement sur place</h2>
                    <p class="text-gray-500 leading-relaxed">Votre réservation est enregistrée ! Veuillez préparer la somme de <strong>{{ $total }}€</strong> en espèces. Le règlement se fera directement au point de retrait avant le départ.</p>
                    @break

                @case('check')
                    <h2 class="font-[900] uppercase italic text-2xl tracking-tighter mb-4 text-blue-900">Paiement par chèque</h2>
                    <p class="text-gray-500 leading-relaxed">Réservation bien prise en compte. Merci de libeller votre chèque de <strong>{{ $total }}€</strong> à l'ordre de <strong>"Milly Évasion"</strong>. Vous devrez nous le remettre lors de la prise en charge du vélo.</p>
                    @break
            @endswitch

            <div class="mt-8 pt-8 border-t border-gray-100 grid grid-cols-2 gap-8">
                <div>
                    <p class="milly-text-mini-label">Point de RDV</p>
                    <p class="font-bold text-sm">Centre-ville, Milly-la-Forêt</p>
                </div>
                <div>
                    <p class="milly-text-mini-label">Besoin d'aide ?</p>
                    <p class="font-bold text-sm">06 .. .. .. ..</p>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ url('/') }}" class="milly-btn-black">Retour à l'accueil</a>
            <button onclick="window.print()" class="px-8 py-4 border-2 border-gray-200 rounded-full font-black uppercase italic text-xs hover:bg-gray-50 transition-colors">
                Imprimer le récapitulatif
            </button>
        </div>
    </div>
</div>
@endsection