<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bike;
use Illuminate\Http\Request;

class AdminBikeController extends Controller
{
    public function index()
    {
        // On récupère tous les vélos en base de données
        $bikes = Bike::all();
        
        // On les envoie à la vue
        return view('admin.bikes.index', compact('bikes'));
    }
    // Affiche le formulaire
    public function create()
    {
        return view('admin.bikes.create');
    }

    // Enregistre le vélo en base de données
    public function store(Request $request)
    {
        // 1. Validation des données
        $validated = $request->validate([
            'serial_number' => 'required|unique:bikes,serial_number',
            'model' => 'required|string|max:255',
            'status' => 'required|in:available,maintenance,rented',
        ]);

        // 2. Création du vélo
        Bike::create($validated);

        // 3. Redirection avec un message de succès
        return redirect()->route('admin.bikes.index')->with('success', 'Vélo ajouté avec succès !');
    }
    public function updateStatus(Bike $bike)
    {
        // Logique de bascule (Toggle)
        if ($bike->status === 'available') {
            $bike->status = 'maintenance';
            $message = 'Le vélo est désormais en maintenance.';
        } else {
            $bike->status = 'available';
            $message = 'Le vélo est de nouveau disponible.';
        }

        $bike->save();

        return redirect()->back()->with('success', $message);
    }
}
