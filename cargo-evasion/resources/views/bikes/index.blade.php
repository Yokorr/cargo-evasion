@extends('layouts.front')

@section('title', 'La Collection — Milly Évasion')

@section('content')
<div x-data="bookingSystem" class="pt-40 pb-40 min-h-screen">
    
    <div class="px-6 mb-20 max-w-7xl mx-auto">
        <h1 class="milly-h1">La Flotte<span class="text-emerald-500">.</span></h1>
        <p class="milly-label mt-6 ml-2">Explorez Milly-la-Forêt avec style</p>
    </div>

    <div class="milly-grid-flotte">
        @foreach($bikes as $bike)
        <div @click="initBooking({{ json_encode($bike) }})" class="group cursor-pointer">
            <div class="milly-card-bike">
                <img src="{{ $bike->image ?? 'https://images.unsplash.com/photo-1558981403-c5f91adaca60?auto=format&fit=crop&q=80' }}" 
                     class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors"></div>
            </div>
            <div class="mt-8 flex justify-between items-end px-4">
                <div>
                    <h2 class="milly-h2">{{ $bike->model }}</h2>
                    <p class="milly-bike-card-price">Dès {{ $bike->price_morning }}€</p>
                </div>
                <div class="milly-btn-black">Découvrir</div>
            </div>
        </div>
        @endforeach
    </div>

    <div x-show="openDrawer" x-cloak class="fixed inset-0 z-[100] overflow-hidden">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-xl" @click="openDrawer = false" 
             x-show="openDrawer" x-transition:enter="ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"></div>
        
        <section class="absolute inset-y-0 right-0 max-w-full flex">
            <div class="w-screen max-w-xl" x-show="openDrawer" 
                 x-transition:enter="transform transition ease-out duration-700" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" 
                 x-transition:leave="transform transition ease-in duration-500" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
                
                <div class="milly-drawer-content">
                    <button @click="openDrawer = false" class="self-end text-black hover:rotate-90 transition-transform duration-500">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>

                    <div class="mt-8 flex-1" x-show="selectedBike">
                        <h3 class="text-5xl font-black tracking-tighter uppercase italic mb-8" x-text="selectedBike?.model"></h3>
                        
                        <div class="mb-10">
                            <label class="milly-label block mb-4">1. Quand souhaitez-vous rouler ?</label>
                            <input type="date" x-model="selectedDate" min="{{ date('Y-m-d') }}" class="milly-input">
                        </div>

                        <div class="space-y-6">
                            <label class="milly-label block">2. Choisissez votre créneau</label>
                            <div class="grid grid-cols-1 gap-3">
                                <button @click="setSlot('full_day')" 
                                        :class="currentType === 'full_day' ? 'milly-slot-btn-selected' : 'milly-slot-btn milly-slot-btn-unselected'" 
                                        class="milly-slot-btn">
                                    <div class="flex justify-between items-center">
                                        <span class="block text-[10px] font-black uppercase opacity-40 mb-1">Journée complète</span>
                                        <span class="font-black italic" x-text="selectedBike?.price_full_day + '€'"></span>
                                    </div>
                                    <span class="text-xl font-bold">09h00 — 17h30</span>
                                </button>

                                <div class="grid grid-cols-2 gap-3">
                                    <button @click="setSlot('morning')" 
                                            :class="currentType === 'morning' ? 'milly-slot-btn-selected' : 'milly-slot-btn milly-slot-btn-unselected'" 
                                            class="milly-slot-btn">
                                        <span class="block text-[10px] font-black uppercase opacity-40 mb-1">Matin</span>
                                        <span class="text-sm font-bold block">09h — 13h</span>
                                        <span class="text-sm font-black italic mt-1 block text-emerald-500" x-text="selectedBike?.price_morning + '€'"></span>
                                    </button>
                                    <button @click="setSlot('afternoon')" 
                                            :class="currentType === 'afternoon' ? 'milly-slot-btn-selected' : 'milly-slot-btn milly-slot-btn-unselected'" 
                                            class="milly-slot-btn">
                                        <span class="block text-[10px] font-black uppercase opacity-40 mb-1">Après-midi</span>
                                        <span class="text-sm font-bold block">13h30 — 17h30</span>
                                        <span class="text-sm font-black italic mt-1 block text-emerald-500" x-text="selectedBike?.price_afternoon + '€'"></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-12 transition-all duration-500" x-show="result" x-cloak>
                            <template x-if="result?.available">
                                <div class="milly-booking-success-banner animate-bounce-short">
                                    <div>
                                        <p class="text-[10px] font-black uppercase opacity-60 tracking-widest mb-1" x-text="result.label"></p>
                                        <p class="text-5xl font-black"><span x-text="result.total_price"></span>€</p>
                                    </div>
                                    <button @click="addToCart()" class="milly-btn-black hover:bg-white hover:text-black">
                                        <span x-show="!adding">Réserver</span>
                                        <span x-show="adding">Traitement...</span>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection