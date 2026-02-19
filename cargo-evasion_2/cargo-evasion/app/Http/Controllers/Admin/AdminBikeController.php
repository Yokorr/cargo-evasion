<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Ajout pour la gestion des fichiers

class AdminBikeController extends Controller
{
    public function index()
    {
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
            'description' => 'nullable|string',
            'price_morning' => 'required|numeric|min:0',
            'price_afternoon' => 'required|numeric|min:0',
            'price_full_day' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Validation image
        ]);

        // Gestion de l'image au moment de la création
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('bikes', 'public');
        }

        Bike::create($validated);

        return redirect()->route('admin.bikes.index')->with('success', 'Vélo ajouté avec succès !');
    }

    public function update(Request $request, Bike $bike)
    {
        $validated = $request->validate([
            'model' => 'required|string|max:255',
            'price_morning' => 'required|numeric|min:0',
            'price_afternoon' => 'required|numeric|min:0',
            'price_full_day' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Gestion de l'image au moment de la modification
        if ($request->hasFile('image')) {
            // Optionnel : supprimer l'ancienne image si elle existe
            if ($bike->image) {
                Storage::disk('public')->delete($bike->image);
            }
            // Stocker la nouvelle image
            $validated['image'] = $request->file('image')->store('bikes', 'public');
        }

        $bike->status = $request->has('is_maintenance') ? 'maintenance' : 'available';
        $bike->update($validated);

        return back()->with('success', "Les informations de {$bike->model} ont été mises à jour.");
    }
    public function edit(Bike $bike)
    {
        return view('admin.bikes.edit', compact('bike'));
    }
}