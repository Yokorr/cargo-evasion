@extends('layouts.front')

@section('title', 'Problème de paiement — Milly Évasion')

@section('content')
<div class="pt-40 pb-32 bg-[#FBFBFB] min-h-screen flex items-center">
    <div class="max-w-3xl mx-auto px-6 text-center">
        
        <div class="inline-flex items-center justify-center w-20 h-20 bg-rose-500 rounded-[32px] text-white shadow-xl shadow-rose-200 mb-10">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </div>

        <h1 class="milly-h1 text-5xl mb-4">Oups, un petit grain de sable<span class="text-rose-500">.</span></h1>
        <p class="milly-label text-lg mb-12 italic text-rose-900/50">Le paiement n'a pas pu aboutir</p>

        <div class="bg-white border-2 border-rose-100 rounded-[48px] p-10 md:p-16 mb-12 shadow-sm text-left">
            <h2 class="font-[900] uppercase italic text-2xl tracking-tighter mb-4">Pas d'inquiétude !</h2>
            <p class="text-gray-500 leading-relaxed">
                Votre réservation est toujours en attente dans notre système, mais le règlement par carte a été refusé par l'interface Monetico. 
                <br><br>
                Cela peut être dû à un dépassement de plafond, une erreur de saisie ou un problème de connexion avec votre banque.
            </p>

            <div class="mt-8 pt-8 border-t border-gray-100">
                <p class="milly-text-mini-label mb-2">Que faire maintenant ?</p>
                <ul class="space-y-3">
                    <li class="flex items-center gap-3 text-sm font-bold">
                        <span class="w-5 h-5 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center text-[10px]">1</span>
                        Vérifier vos informations bancaires
                    </li>
                    <li class="flex items-center gap-3 text-sm font-bold">
                        <span class="w-5 h-5 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center text-[10px]">2</span>
                        Changer de mode de paiement (Espèces ou Chèque)
                    </li>
                </ul>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('payment.process') }}" class="milly-btn-black !bg-rose-600 hover:!bg-rose-700">
                Réessayer le paiement
            </a>
            <a href="{{ url('/') }}" class="milly-btn-black">Retour à l'accueil</a>
        </div>
        
        <p class="mt-12 text-[10px] text-gray-400 font-bold uppercase tracking-widest">
            Besoin d'aide ? Appelez-nous au <span class="text-gray-600">06 .. .. .. ..</span>
        </p>
    </div>
</div>
@endsection