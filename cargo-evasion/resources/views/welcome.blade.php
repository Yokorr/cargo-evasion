@extends('layouts.front')

@section('title', 'Milly Évasion — Location de vélos au 91')

@section('content')
    <section class="pt-32 md:pt-48 pb-20 px-6 overflow-hidden">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-12 lg:gap-24 items-center">
            
            <div class="space-y-8 md:space-y-10 text-center lg:text-left relative z-10">
                <div class="inline-block px-4 py-2 bg-emerald-50 rounded-full">
                    <span class="text-[10px] font-black uppercase tracking-[0.3em] text-emerald-600 italic">Explorez Milly-la-Forêt autrement</span>
                </div>
                
                <h1 class="text-5xl sm:text-7xl lg:text-8xl font-[900] text-black leading-[0.85] tracking-tighter uppercase italic">
                    L'échappée<br><span class="text-emerald-500">sauvage.</span>
                </h1>
                
                <p class="text-base md:text-lg text-gray-500 leading-relaxed max-w-md mx-auto lg:mx-0 font-medium">
                    Louez votre vélo cargo électrique au cœur de Milly. Idéal pour vos balades en forêt de Fontainebleau ou vos sorties au Cyclop.
                </p>
                
                <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4 pt-4">
                    <a href="{{ route('bikes.index') }}" class="px-10 py-5 bg-black text-white text-xs font-black uppercase tracking-widest rounded-full shadow-2xl hover:bg-emerald-600 transition transform hover:scale-105">
                        Réserver mon vélo
                    </a>
                </div>
            </div>

            <div class="relative mt-12 lg:mt-0">
                <div class="absolute -top-20 -right-20 w-64 md:w-80 h-64 md:h-80 bg-emerald-100 rounded-full blur-[80px] md:blur-[100px] opacity-40"></div>
                
                <div class="relative aspect-[4/5] sm:aspect-[16/10] lg:aspect-[4/5] bg-gray-900 rounded-[32px] md:rounded-[40px] shadow-3xl overflow-hidden border-[8px] md:border-[12px] border-white">
                    <img src="https://images.unsplash.com/photo-1616422285623-13ff0167c95c?q=80&w=1000&auto=format&fit=crop" 
                         alt="Vélo Cargo Milly" class="w-full h-full object-cover opacity-80">
                    
                    <div class="absolute bottom-6 left-6 md:bottom-10 md:left-10 bg-white/95 backdrop-blur-md p-4 md:p-6 rounded-[24px] md:rounded-[32px] shadow-2xl flex items-center gap-3 md:gap-5">
                        <div class="w-10 h-10 md:w-14 md:h-14 bg-emerald-500 rounded-xl md:rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200">
                            <svg class="w-5 h-5 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <div>
                            <p class="text-[8px] md:text-[10px] text-gray-400 font-black uppercase tracking-widest mb-0.5 md:mb-1">Dispo à Milly</p>
                            <p class="text-lg md:text-2xl font-[900] text-black italic uppercase tracking-tighter">
                                {{ $availableBikesCount ?? 0 }} Modèles
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection