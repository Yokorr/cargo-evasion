@extends('layouts.front')

@section('title', 'La Collection — Milly Évasion')

@section('content')
<div x-data="{ 
    openDrawer: false, 
    selectedBike: null,
    mode: 'slots',
    // On initialise à aujourd'hui, mais on empêche le passé en HTML plus bas
    selectedDate: new Date().toISOString().slice(0, 10),
    start: '', 
    end: '', 
    result: null,
    loading: false,
    adding: false,
    currentType: '',

    initBooking(bike) {
        this.selectedBike = bike;
        this.openDrawer = true;
        this.result = null;
        this.start = '';
        this.end = '';
        this.mode = 'slots';
    },

    setSlot(type) {
        this.currentType = type;
        if(type === 'morning') {
            this.start = this.selectedDate + ' 09:00';
            this.end = this.selectedDate + ' 13:00';
        } else if(type === 'afternoon') {
            this.start = this.selectedDate + ' 13:30';
            this.end = this.selectedDate + ' 17:30';
        } else if(type === 'full_day') {
            this.start = this.selectedDate + ' 09:00';
            this.end = this.selectedDate + ' 17:30';
        }
        this.check();
    }, // La virgule manquante est ici

    check() {
        if(!this.start || !this.end) return;
        this.loading = true;
        fetch('{{ route('bookings.check') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ 
                bike_id: this.selectedBike.id, 
                start_date: this.start, 
                end_date: this.end, 
                type: this.currentType 
            })
        })
        .then(res => res.json())
        .then(data => { 
            this.result = data; 
            this.loading = false; 
        })
        .catch(() => { this.loading = false; });
    },

    addToCart() {
        this.adding = true;
        fetch('{{ route('cart.add') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ 
                bike_id: this.selectedBike.id, 
                start_date: this.start, 
                end_date: this.end,
                total_price: this.result.total_price,
                label: this.result.label
            })
        })
        .then(() => { window.location.href = '{{ route('cart.index') }}'; });
    }
}" class="pt-40 pb-40 min-h-screen">

    <div class="px-6 mb-20 max-w-7xl mx-auto">
        <h1 class="text-7xl md:text-9xl font-[900] leading-[0.8] tracking-tighter uppercase italic text-black">
            La Flotte<span class="text-emerald-500">.</span>
        </h1>
        <p class="text-gray-400 font-bold uppercase tracking-[0.3em] mt-6 ml-2 italic">Explorez Milly-la-Forêt avec style</p>
    </div>

    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-16">
        @foreach($bikes as $bike)
        <div @click="initBooking({{ json_encode($bike) }})" class="group cursor-pointer">
            <div class="aspect-[4/5] bg-gray-100 rounded-[40px] overflow-hidden shadow-2xl relative border-8 border-white group-hover:border-emerald-500/10 transition-all duration-500">
                <img src="{{ $bike->image ?? 'https://images.unsplash.com/photo-1558981403-c5f91adaca60?auto=format&fit=crop&q=80' }}" 
                     class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors"></div>
            </div>
            <div class="mt-8 flex justify-between items-end px-4">
                <div>
                    <h2 class="text-4xl font-[900] uppercase italic tracking-tighter">{{ $bike->model }}</h2>
                    <p class="text-emerald-600 font-black text-xs uppercase tracking-[0.2em] mt-2 italic">Dès {{ $bike->price_morning }}€</p>
                </div>
                <div class="bg-black text-white px-8 py-4 rounded-full text-[10px] font-black uppercase tracking-widest group-hover:bg-emerald-500 transition-all transform group-active:scale-95">
                    Découvrir
                </div>
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
                
                <div class="h-full bg-white shadow-2xl flex flex-col p-12 overflow-y-auto">
                    <button @click="openDrawer = false" class="self-end text-black hover:rotate-90 transition-transform duration-500">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>

                    <div class="mt-8 flex-1" x-show="selectedBike">
                        <h3 class="text-5xl font-black tracking-tighter uppercase italic mb-8" x-text="selectedBike?.model"></h3>
                        
                        <div class="mb-10">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 block mb-4 italic">1. Quand souhaitez-vous rouler ?</label>
                            <input type="date" x-model="selectedDate" min="{{ date('Y-m-d') }}" 
                                   class="w-full border-2 border-gray-100 rounded-2xl p-4 text-xl font-bold focus:border-black transition">
                        </div>

                        <div x-show="mode === 'slots'" class="space-y-6">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 block italic">2. Choisissez votre créneau</label>
                            <div class="grid grid-cols-1 gap-3">
                                <button @click="setSlot('full_day')" 
                                        :class="currentType === 'full_day' ? 'bg-black text-white' : 'bg-gray-50 text-black'" 
                                        class="p-6 rounded-[24px] text-left transition-all">
                                    <div class="flex justify-between items-center">
                                        <span class="block text-[10px] font-black uppercase opacity-40 mb-1">Journée complète</span>
                                        <span class="font-black italic" x-text="selectedBike?.price_full_day + '€'"></span>
                                    </div>
                                    <span class="text-xl font-bold">09h00 — 17h30</span>
                                </button>

                                <div class="grid grid-cols-2 gap-3">
                                    <button @click="setSlot('morning')" 
                                            :class="currentType === 'morning' ? 'bg-black text-white' : 'bg-gray-50 text-black'" 
                                            class="p-6 rounded-[24px] text-left transition-all">
                                        <span class="block text-[10px] font-black uppercase opacity-40 mb-1">Matin</span>
                                        <span class="text-sm font-bold block">09h — 13h</span>
                                        <span class="text-sm font-black italic mt-1 block text-emerald-500" x-text="selectedBike?.price_morning + '€'"></span>
                                    </button>
                                    <button @click="setSlot('afternoon')" 
                                            :class="currentType === 'afternoon' ? 'bg-black text-white' : 'bg-gray-50 text-black'" 
                                            class="p-6 rounded-[24px] text-left transition-all">
                                        <span class="block text-[10px] font-black uppercase opacity-40 mb-1">Après-midi</span>
                                        <span class="text-sm font-bold block">13h30 — 17h30</span>
                                        <span class="text-sm font-black italic mt-1 block text-emerald-500" x-text="selectedBike?.price_afternoon + '€'"></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-12 transition-all duration-500" x-show="result" x-cloak>
                            <template x-if="result?.available">
                                <div class="bg-emerald-500 text-white p-8 rounded-[32px] shadow-2xl flex justify-between items-center animate-bounce-short">
                                    <div>
                                        <p class="text-[10px] font-black uppercase opacity-60 tracking-widest mb-1" x-text="result.label"></p>
                                        <p class="text-5xl font-black"><span x-text="result.total_price"></span>€</p>
                                    </div>
                                    <button @click="addToCart()" 
                                            class="bg-black text-white px-8 py-4 rounded-full font-black text-xs uppercase tracking-widest hover:bg-white hover:text-black transition-all">
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