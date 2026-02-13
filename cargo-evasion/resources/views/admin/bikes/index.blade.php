<x-app-layout>
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
                            <form action="{{ route('admin.bikes.update', $bike) }}" method="POST">
                                @csrf @method('PUT')
                                
                                <td class="p-6 min-w-[300px]">
                                    <div class="font-black uppercase italic text-lg leading-none mb-3">{{ $bike->model }}</div>
                                    <div class="text-[10px] text-gray-400 font-black uppercase mb-2">Description courte :</div>
                                    <textarea name="description" 
                                            rows="2" 
                                            class="w-full p-3 bg-gray-50 border-2 border-transparent rounded-xl text-xs font-medium focus:bg-white focus:border-emerald-500 outline-none transition-all resize-none"
                                            placeholder="Ex: Assistance Bosch, 2 places enfants...">{{ $bike->description }}</textarea>
                                    <div class="text-[10px] text-gray-400 font-bold uppercase mt-2">N° Série : {{ $bike->serial_number }}</div>
                                </td>

                                <td class="p-6">
                                    <div class="flex items-center justify-center gap-2">
                                        <div class="relative">
                                            <input type="number" name="price_morning" value="{{ $bike->price_morning }}" class="w-20 p-2 pl-6 border-2 border-gray-100 rounded-xl font-bold text-sm focus:border-emerald-500 outline-none">
                                            <span class="absolute left-2 top-2.5 text-[10px] text-gray-400 font-black">M</span>
                                        </div>
                                        <div class="relative">
                                            <input type="number" name="price_afternoon" value="{{ $bike->price_afternoon }}" class="w-20 p-2 pl-6 border-2 border-gray-100 rounded-xl font-bold text-sm focus:border-emerald-500 outline-none">
                                            <span class="absolute left-2 top-2.5 text-[10px] text-gray-400 font-black">A</span>
                                        </div>
                                        <div class="relative">
                                            <input type="number" name="price_full_day" value="{{ $bike->price_full_day }}" class="w-20 p-2 pl-6 border-2 border-gray-100 rounded-xl font-bold text-sm focus:border-emerald-500 outline-none">
                                            <span class="absolute left-2 top-2.5 text-[10px] text-gray-400 font-black">J</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="p-6 text-center">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="is_maintenance" class="sr-only peer" {{ $bike->status === 'maintenance' ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                                    </label>
                                    <div class="text-[8px] font-black uppercase mt-1 {{ $bike->status === 'maintenance' ? 'text-amber-600' : 'text-gray-300' }}">
                                        {{ $bike->status === 'maintenance' ? 'Hors-service' : 'En service' }}
                                    </div>
                                </td>

                                <td class="p-6 text-right">
                                    <button type="submit" class="milly-btn-black !py-3 !px-6 text-[10px] whitespace-nowrap">
                                        Sauvegarder
                                    </button>
                                </td>
                            </form>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>