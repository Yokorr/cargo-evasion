<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ajouter un nouveau vélo</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.bikes.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700">Numéro de série</label>
                        <input type="text" name="serial_number" class="w-full rounded-md border-gray-300" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Modèle</label>
                        <input type="text" name="model" class="w-full rounded-md border-gray-300" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Statut</label>
                        <select name="status" class="w-full rounded-md border-gray-300">
                            <option value="available">Disponible</option>
                            <option value="maintenance">En maintenance</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>