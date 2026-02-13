<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm sm:rounded-[32px]">
                <h1 class="text-3xl font-black uppercase italic mb-8">Nouveau Modèle</h1>
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-xl">
                        <p class="font-black uppercase text-xs mb-2">Oups ! Il y a un petit souci :</p>
                        <ul class="list-disc ml-5 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('admin.bikes.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="milly-label ml-4 mb-2 block">Modèle</label>
                            <input type="text" name="model" value="{{ old('model') }}" class="milly-checkout-input border-2 border-gray-50 focus:border-emerald-500" placeholder="ex: Cargo XL" required>
                        </div>
                        <div>
                            <label class="milly-label ml-4 mb-2 block">Numéro de Série</label>
                            <input type="text" name="serial_number" value="{{ old('serial_number') }}" class="milly-checkout-input border-2 border-gray-50 focus:border-emerald-500" placeholder="ex: MIL-2026-001" required>
                        </div>
                    </div>

                    <div>
                        <label class="milly-label ml-4 mb-2 block">Statut Initial</label>
                        <select name="status" class="milly-checkout-input border-2 border-gray-100">
                            <option value="available">Disponible immédiatement</option>
                            <option value="maintenance">En maintenance / Préparation</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="milly-label ml-4 mb-2 block">Description du modèle</label>
                        <textarea name="description" 
                                rows="3" 
                                class="milly-checkout-input border-2 border-gray-50 focus:border-emerald-500 w-full" 
                                placeholder="Détails techniques, nombre d'enfants possibles, autonomie batterie...">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="milly-label ml-4 mb-2 block text-[8px]">Prix Matin (€)</label>
                            <input type="number" name="price_morning" value="{{ old('price_morning', 0) }}" class="milly-checkout-input border-2 border-gray-50" required>
                        </div>
                        <div>
                            <label class="milly-label ml-4 mb-2 block text-[8px]">Prix Après-midi (€)</label>
                            <input type="number" name="price_afternoon" value="{{ old('price_afternoon', 0) }}" class="milly-checkout-input border-2 border-gray-50" required>
                        </div>
                        <div>
                            <label class="milly-label ml-4 mb-2 block text-[8px]">Prix Journée (€)</label>
                            <input type="number" name="price_full_day" value="{{ old('price_full_day', 0) }}" class="milly-checkout-input border-2 border-gray-50" required>
                        </div>
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="milly-btn-black w-full py-5">
                            Créer et ajouter à la flotte
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>