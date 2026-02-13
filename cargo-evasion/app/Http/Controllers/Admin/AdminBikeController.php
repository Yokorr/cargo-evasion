<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bike;
use Illuminate\Http\Request;

class AdminBikeController extends Controller
{
    public function index()
    {
        // On récupère tous les vélos (disponibles et en maintenance)
        $bikes = Bike::all();
        return view('admin.bikes.index', compact('bikes'));
    }

    public function create()
    {
        return view('admin.bikes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'serial_number' => 'required|unique:bikes,serial_number',
            'model' => 'required|string|max:255',
            'status' => 'required|in:available,maintenance,rented',
            'description' => 'nullable|string', // Ajoute cette validation
            'price_morning' => 'required|numeric|min:0',
            'price_afternoon' => 'required|numeric|min:0',
            'price_full_day' => 'required|numeric|min:0',
        ]);

        Bike::create($validated);

        return redirect()->route('admin.bikes.index')->with('success', 'Vélo ajouté avec succès !');
    }

    public function update(Request $request, Bike $bike)
    {
        $validated = $request->validate([
            'price_morning' => 'required|numeric|min:0',
            'price_afternoon' => 'required|numeric|min:0',
            'price_full_day' => 'required|numeric|min:0',
            'description' => 'nullable|string', // On autorise la modification ici
        ]);

        // Gestion du statut
        $bike->status = $request->has('is_maintenance') ? 'maintenance' : 'available';
        
        // Mise à jour de tout le reste
        $bike->update($validated);

        return back()->with('success', "Les informations de {$bike->model} ont été mises à jour.");
    }

}