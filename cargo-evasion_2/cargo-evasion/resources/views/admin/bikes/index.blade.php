@extends('layouts.admin')

@section('content')
{{-- On supprime <x-app-layout> et on garde juste le contenu --}}

<div class="mb-10 flex justify-between items-center">
    <div>
        <h2 class="text-4xl font-black italic tracking-tighter uppercase">Gestion <span class="text-emerald-500">Flotte</span></h2>
        <p class="text-gray-500 font-medium">Modifiez vos vélos et leurs tarifs en temps réel.</p>
    </div>
    <a href="{{ route('admin.bikes.create') }}" class="bg-black text-white px-8 py-4 rounded-2xl font-black uppercase italic tracking-tighter hover:bg-emerald-500 transition-all shadow-[4px_4px_0px_0px_rgba(16,185,129,1)]">
        + Ajouter un vélo
    </a>
</div>

@if ($errors->any())
    <div class="mb-6 p-4 bg-red-500 text-white rounded-2xl font-bold uppercase text-xs tracking-widest">
        <ul>
            @foreach ($errors->all() as $error)
                <li>⚠ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white border-2 border-black rounded-[32px] overflow-hidden shadow-2xl">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-black text-white uppercase text-[10px] tracking-widest">
                <th class="p-6">Modèle / N° Série</th>
                <th class="p-6 text-center">Tarifs (M | A | J)</th>
                <th class="p-6 text-center">Statut</th>
                <th class="p-6 text-right">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y-2 divide-gray-100">
            @foreach($bikes as $bike)
            <tr class="hover:bg-gray-50/50 transition-colors">
                {{-- Formulaire unique par ligne --}}
                <form id="form-{{ $bike->id }}" action="{{ route('admin.bikes.update', $bike) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <input type="hidden" name="model" value="{{ $bike->model }}">
                </form>
                    
                <td class="p-6 min-w-[350px]">
                    <div class="flex items-center gap-6 mb-4">
                        <div class="w-32 h-24 bg-gray-100 rounded-2xl flex items-center justify-center overflow-hidden border border-gray-200">
                            @if($bike->image)
                                <img src="{{ asset('storage/' . $bike->image) }}" class="w-full h-full object-contain p-2">
                            @else
                                <span class="text-[8px] font-black uppercase text-gray-400">Pas d'image</span>
                            @endif
                        </div>
                        <div>
                            <div class="font-black uppercase italic text-xl leading-none">{{ $bike->model }}</div>
                            <div class="text-[10px] text-gray-400 font-bold uppercase mt-1">N° Série : {{ $bike->serial_number }}</div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <input type="file" name="image" form="form-{{ $bike->id }}" class="text-xs font-bold text-gray-400">
                        <textarea name="description" form="form-{{ $bike->id }}" rows="2" class="w-full p-3 bg-gray-50 border-2 border-transparent rounded-xl text-xs font-medium focus:border-emerald-500 outline-none transition-all resize-none">{{ $bike->description }}</textarea>
                    </div>
                </td>

                <td class="p-6">
                    <div class="flex items-center justify-center gap-2">
                        @foreach(['morning' => 'M', 'afternoon' => 'A', 'full_day' => 'J'] as $key => $label)
                        <div class="relative">
                            <input type="number" step="0.01" name="price_{{ $key }}" form="form-{{ $bike->id }}" value="{{ $bike->{'price_'.$key} }}" class="w-20 p-2 pl-6 border-2 border-gray-100 rounded-xl font-bold text-sm focus:border-emerald-500 outline-none">
                            <span class="absolute left-2 top-2.5 text-[10px] text-gray-400 font-black">{{ $label }}</span>
                        </div>
                        @endforeach
                    </div>
                </td>

                <td class="p-6 text-center">
                    <div class="flex flex-col items-center">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_maintenance" form="form-{{ $bike->id }}" class="sr-only peer" {{ $bike->status === 'maintenance' ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-amber-500 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full"></div>
                        </label>
                        <span class="text-[8px] font-black uppercase mt-1 {{ $bike->status === 'maintenance' ? 'text-amber-600' : 'text-gray-300' }}">
                            {{ $bike->status === 'maintenance' ? 'Maintenance' : 'En service' }}
                        </span>
                    </div>
                </td>

                <td class="p-6 text-right">
                    <button type="submit" form="form-{{ $bike->id }}" class="bg-black text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase hover:bg-emerald-500 transition-all">
                        Sauvegarder
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-8">
    {{ $bikes->links() }}
</div>

@endsection