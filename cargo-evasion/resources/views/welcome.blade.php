@extends('layouts.front')

@section('title', 'Milly Évasion — Location de vélos au 91')

@section('content')
    <section class="pt-32 md:pt-48 pb-20 px-6 overflow-hidden">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-12 lg:gap-24 items-center">
            
            <div class="space-y-8 md:space-y-10 text-center lg:text-left relative z-10">
                <div class="milly-badge-green">
                    Explorez Milly-la-Forêt autrement
                </div>
                
                <h1 class="milly-hero-title">
                    L'échappée<br><span class="text-emerald-500">sauvage.</span>
                </h1>
                
                <p class="text-base md:text-lg text-gray-500 leading-relaxed max-w-md mx-auto lg:mx-0 font-medium">
                    Louez votre vélo cargo électrique au cœur de Milly. Idéal pour vos balades en forêt de Fontainebleau ou vos sorties au Cyclop.
                </p>
                
                <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4 pt-4">
                    <a href="{{ route('bikes.index') }}" class="milly-btn-main">
                        Réserver mon vélo
                    </a>
                </div>
            </div>

            <div class="relative mt-12 lg:mt-0">
                <div class="absolute -top-20 -right-20 w-64 md:w-80 h-64 md:h-80 bg-emerald-100 rounded-full blur-[80px] md:blur-[100px] opacity-40"></div>
                
                <div class="milly-img-frame">
                    <img src="https://images.unsplash.com/photo-1616422285623-13ff0167c95c?q=80&w=1000&auto=format&fit=crop" 
                         alt="Vélo Cargo Milly" class="w-full h-full object-cover opacity-80">
                    
                    <div class="milly-floating-card">
                        <div class="w-10 h-10 md:w-14 md:h-14 bg-emerald-500 rounded-xl md:rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200">
                            <svg class="w-5 h-5 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <div>
                            <p class="milly-text-mini-label">Dispo à Milly</p>
                            <p class="milly-text-mini-title">
                                {{ $availableBikesCount ?? 0 }} Modèles
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection