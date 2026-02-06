@extends('layouts.front')

@section('title', 'La Collection — Milly Évasion')

@section('content')
<div x-data="{ 
    openDrawer: false, 
    selectedBike: null,
    mode: 'slots',
    selectedDate: new Date().toISOString().slice(0, 10),
    start: '', 
    end: '', 
    result: null,
    loading: false,
    adding: false,

    initBooking(bike) {
        this.selectedBike = bike;
        this.openDrawer = true;
        this.result = null;
        this.start = '';
        this.end = '';
        this.mode = 'slots';
    },

    setSlot(type) {
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
    },

    check() {
        if(!this.start || !this.end) return;
        this.loading = true;
        fetch('{{ route('bookings.check') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ bike_id: this.selectedBike.id, start_date: this.start, end_date: this.end })
        })
        .then(res => res.json())
        .then(data => { this.result = data; this.loading = false; });
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
}" class="pt-32 pb-40">

    <div class="px-6 mb-20 max-w-7xl mx-auto">
        <h1 class="text-7xl md:text-9xl font-[900] leading-none tracking-tighter uppercase italic text-black">
            La Flotte<span class="text-emerald-500">.</span>
        </h1>
        <p class="text-gray-400 font-bold uppercase tracking-[0.3em] mt-4">Sélectionnez votre compagnon de route</p>
    </div>

    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-16">
        @foreach($bikes as $bike)
        <div @click="initBooking(@json($bike))" class="group cursor-pointer">
            <div class="aspect-[4/5] bg-gray-100 rounded-[40px] overflow-hidden shadow-2xl relative">
                <img src="https://images.unsplash.com/photo-1558981403-c5f91adaca60?auto=format&fit=crop&q=80" 
                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-black/20 group-hover:bg-black/0 transition-colors"></div>
            </div>
            <div class="mt-8 flex justify-between items-end">
                <div>
                    <h2 class="text-4xl font-[900] uppercase italic tracking-tighter">{{ $bike->model }}</h2>
                    <p class="text-emerald-600 font-bold text-sm uppercase tracking-widest mt-2">À partir de {{ $bike->prices->min('amount') }}€</p>
                </div>
                <div class="bg-black text-white px-8 py-4 rounded-full text-[10px] font-black uppercase tracking-widest group-hover:bg-emerald-500 transition-colors">
                    Découvrir
                </div>
            </div>
        </div>
        @endforeach
    </div>

    </div>
@endsection