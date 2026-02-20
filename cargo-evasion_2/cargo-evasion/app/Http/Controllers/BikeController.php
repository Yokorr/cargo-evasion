<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use Illuminate\Http\Request;

class BikeController extends Controller
{
    public function index()
    {
        $bikes = Bike::where('status', 'available')
            ->with(['bookings' => function($query) {
                // On récupère les réservations qui bloquent le calendrier
                // On inclut 'pending' pour éviter les doubles résas pendant que les gens paient
                $query->where('end_date', '>=', now())
                    ->whereIn('status', ['pending', 'confirmed']);
            }])
            ->get()
            ->map(function($bike) {
                // On garde ton calcul de prix d'appel (Dès XX€)
                $bike->lowest_price = min($bike->price_morning, $bike->price_afternoon, $bike->price_full_day);
                return $bike;
            });

        return view('bikes.index', compact('bikes'));
    }
}