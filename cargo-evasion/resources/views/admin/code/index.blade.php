<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestion des Codes Journaliers</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg border border-green-200 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white p-8 shadow-sm sm:rounded-lg mb-8 border border-gray-100">
                <h3 class="text-lg font-medium text-gray-900 mb-6">Ajouter un code pour une date</h3>
                <form action="{{ route('admin.codes.store') }}" method="POST" class="flex flex-col md:flex-row gap-6 items-end">
                    @csrf
                    <div class="flex-1 w-full">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date du jour</label>
                        <input type="date" name="date_day" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    <div class="flex-1 w-full">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Code de la boîte (4-6 chiffres)</label>
                        <input type="text" name="access_code" placeholder="Ex: 8502" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    <button type="submit" class="w-full md:w-auto px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 transition duration-150">
                        Enregistrer le code
                    </button>
                </form>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden border border-gray-100">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Code d'accès</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($codes as $code)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                {{ \Carbon\Carbon::parse($code->date_day)->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 bg-blue-50 text-blue-700 font-mono font-bold rounded-lg border border-blue-100">
                                    {{ $code->access_code }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-6 py-10 text-center text-gray-500 italic">Aucun code enregistré pour le moment.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>