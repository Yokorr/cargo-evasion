<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function check(Request $request)
    {
        $bike = Bike::findOrFail($request->bike_id);
        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);

        if (!$bike->isAvailable($start, $end)) {
            return response()->json(['available' => false, 'message' => 'Déjà réservé.']);
        }

        $durationHours = $start->diffInHours($end);

        // 1. On cherche d'abord un forfait exact (ex: Matinée 4h)
        $priceTier = $bike->prices()->where('duration_hours', $durationHours)->first();

        // 2. Si pas de forfait exact, on calcule (ex: Prix de base à l'heure)
        // On peut imaginer un prix par défaut ou prendre le tarif le plus bas divisé par ses heures
        if (!$priceTier) {
            $basePrice = $bike->prices()->min('amount') / 4; // Estimation si pas de prix heure
            $totalPrice = round($basePrice * $durationHours, 2);
            $label = "Tarif horaire sur mesure";
        } else {
            $totalPrice = $priceTier->amount;
            $label = $priceTier->label;
        }

        return response()->json([
            'available' => true,
            'duration' => $durationHours,
            'total_price' => $totalPrice,
            'label' => $label
        ]);
    }
}
