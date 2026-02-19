@extends('layouts.front')

@section('content')
<div class="pt-64 pb-40 text-center" x-data="{ submit() { $refs.form.submit() } }" x-init="setTimeout(() => submit(), 1500)">
    <div class="max-w-md mx-auto px-6">
        <div class="mb-12 flex justify-center">
            <div class="w-20 h-20 border-4 border-emerald-500 border-t-transparent rounded-full animate-spin"></div>
        </div>

        <h1 class="text-4xl font-[900] italic tracking-tighter uppercase mb-4">Connexion sécurisée<span class="text-emerald-500">...</span></h1>
        <p class="text-gray-400 font-medium leading-relaxed">
            Nous vous redirigeons vers l'interface de paiement sécurisée de notre banque **Monetico**.
        </p>

        <form x-ref="form" action="{{ $url }}" method="POST">
            @foreach($params as $name => $value)
                <input type="hidden" name="{{ $name }}" value="{{ $value }}">
            @endforeach
            <noscript>
                <button type="submit" class="mt-8 bg-black text-white px-8 py-4 rounded-full font-black uppercase tracking-widest text-xs">
                    Cliquez ici si vous n'êtes pas redirigé
                </button>
            </noscript>
        </form>
    </div>
</div>
@endsection