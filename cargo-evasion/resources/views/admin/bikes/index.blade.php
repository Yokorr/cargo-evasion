<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestion de la Flotte - Sports Carbone') }}
            </h2>
            <a href="{{ route('admin.bikes.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                + Ajouter un vélo
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Modèle</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">N° de Série</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($bikes as $bike)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $bike->model }}</div>
                                <div class="text-xs text-gray-500 font-mono">{{ $bike->serial_number }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $bike->status == 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $bike->status === 'available' ? 'Disponible' : 'Maintenance' }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    @foreach($bike->prices as $price)
                                        <div class="text-xs flex justify-between bg-gray-50 p-1 rounded">
                                            <span class="font-medium">{{ $price->label }}</span>
                                            <span class="text-emerald-700 font-bold">{{ $price->amount }}€</span>
                                        </div>
                                    @endforeach
                                    
                                    <form action="{{ route('admin.bikes.storePrice', $bike) }}" method="POST" class="mt-2 flex gap-1">
                                        @csrf
                                        <input type="text" name="label" placeholder="Nom (ex: Matin)" class="text-xs p-1 border rounded w-20" required>
                                        <input type="number" name="amount" placeholder="€" class="text-xs p-1 border rounded w-12" required>
                                        <input type="number" name="duration_hours" placeholder="H" class="text-xs p-1 border rounded w-10" required title="Durée en heures">
                                        <button type="submit" class="bg-gray-800 text-white text-xs px-2 py-1 rounded hover:bg-black">+</button>
                                    </form>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.bikes.updateStatus', $bike) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-xs font-bold uppercase tracking-wider {{ $bike->status === 'available' ? 'text-amber-600' : 'text-emerald-600' }}">
                                        {{ $bike->status === 'available' ? '🔧 Maintenance' : '✅ Réparé' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                            @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>