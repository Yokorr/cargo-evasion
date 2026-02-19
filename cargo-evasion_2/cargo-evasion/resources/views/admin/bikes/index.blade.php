<x-app-layout>
    @if ($errors->any())
        <div class="max-w-7xl mx-auto mt-4 sm:px-6 lg:px-8">
            <div class="bg-red-500 text-white p-4 rounded-xl font-bold uppercase text-xs tracking-widest">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>⚠ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-black uppercase italic tracking-tighter">Gestion Flotte</h1>
            <a href="{{ route('admin.bikes.create') }}" class="milly-btn-main !py-3 !px-6 text-[10px]">
                + Ajouter un vélo
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-[32px] overflow-hidden border border-gray-100">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="p-6 milly-label">Modèle / N° Série</th>
                            <th class="p-6 milly-label text-center">Tarifs (Matin | Aprem | Jour)</th>
                            <th class="p-6 milly-label text-center">Maintenance</th>
                            <th class="p-6 milly-label text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($bikes as $bike)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <form id="form-{{ $bike->id }}" action="{{ route('admin.bikes.update', $bike) }}" method="POST" enctype="multipart/form-data">
                                @csrf @method('PUT')
                                <input type="hidden" name="model" value="{{ $bike->model }}">
                            </form>
                                
                            <td class="p-6 min-w-[300px]">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="milly-card-bike h-64 bg-gray-50 flex items-center justify-center overflow-hidden">
                                        @if($bike->image)
                                            <img src="{{ asset('storage/' . $bike->image) }}" 
                                                class="w-full h-full object-contain p-4 transition-transform duration-1000 group-hover:scale-110">
                                        @else
                                            <div class="bg-emerald-50 text-emerald-500 font-black uppercase italic text-[10px]">Image à venir</div>
                                        @endif
                                    </div>

                                    <div>
                                        <div class="font-black uppercase italic text-lg leading-none">{{ $bike->model }}</div>
                                        <div class="text-[10px] text-gray-400 font-bold uppercase mt-1">N° Série : {{ $bike->serial_number }}</div>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[10px] text-gray-400 font-black uppercase block">Changer la photo :</label>
                                    <input type="file" 
                                        name="image" 
                                        form="form-{{ $bike->id }}"
                                        class="block w-full text-[10px] text-gray-500
                                                file:mr-4 file:py-2 file:px-4
                                                file:rounded-full file:border-0
                                                file:text-[10px] file:font-black file:uppercase
                                                file:bg-emerald-50 file:text-emerald-700
                                                hover:file:bg-emerald-100 transition-all cursor-pointer">
                                </div>

                                <div class="text-[10px] text-gray-400 font-black uppercase mb-2 mt-4">Description :</div>
                                <textarea name="description" 
                                        form="form-{{ $bike->id }}"
                                        rows="2" 
                                        class="w-full p-3 bg-gray-50 border-2 border-transparent rounded-xl text-xs font-medium focus:bg-white focus:border-emerald-500 outline-none transition-all resize-none">{{ $bike->description }}</textarea>
                            </td>

                            <td class="p-6">
                                <div class="flex items-center justify-center gap-2">
                                    @foreach(['morning' => 'M', 'afternoon' => 'A', 'full_day' => 'J'] as $key => $label)
                                    <div class="relative">
                                        <input type="number" step="0.01" name="price_{{ $key }}" 
                                               form="form-{{ $bike->id }}"
                                               value="{{ $bike->{'price_'.$key} }}" 
                                               class="w-20 p-2 pl-6 border-2 border-gray-100 rounded-xl font-bold text-sm focus:border-emerald-500 outline-none">
                                        <span class="absolute left-2 top-2.5 text-[10px] text-gray-400 font-black">{{ $label }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </td>

                            <td class="p-6 text-center">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_maintenance" 
                                           form="form-{{ $bike->id }}"
                                           class="sr-only peer" {{ $bike->status === 'maintenance' ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                                </label>
                                <div class="text-[8px] font-black uppercase mt-1 {{ $bike->status === 'maintenance' ? 'text-amber-600' : 'text-gray-300' }}">
                                    {{ $bike->status === 'maintenance' ? 'Hors-service' : 'En service' }}
                                </div>
                            </td>

                            <td class="p-6 text-right">
                                <button type="submit" form="form-{{ $bike->id }}" class="milly-btn-black !py-3 !px-6 text-[10px] whitespace-nowrap">
                                    Sauvegarder
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>