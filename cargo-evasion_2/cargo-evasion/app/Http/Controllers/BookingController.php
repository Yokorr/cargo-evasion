<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function check(Request $request)
    {
        $bike = Bike::findOrFail($request->bike_id);
        $date = $request->date; // Format attendu : 'YYYY-MM-DD'
        $type = $request->type; 

        // 1. Définition des heures théoriques du créneau demandé
        $startTime = "";
        $endTime = "";

        if ($type == 'morning') {
            $startTime = "$date 09:00:00";
            $endTime = "$date 13:00:00";
            $price = $bike->price_morning;
            $label = "Matinée (9h-13h)";
        } elseif ($type == 'afternoon') {
            $startTime = "$date 13:30:00";
            $endTime = "$date 17:30:00";
            $price = $bike->price_afternoon;
            $label = "Après-midi (13h30-17h30)";
        } else { // full_day
            $startTime = "$date 09:00:00";
            $endTime = "$date 17:30:00";
            $price = $bike->price_full_day;
            $label = "Journée complète";
        }


    // 2. Vérification des collisions en base de données
    $isBooked = Booking::where('bike_id', $bike->id)
        ->where('status', '!=', 'cancelled') // VERROU 1 : On ignore les annulations
        ->where(function ($query) use ($startTime, $endTime) {
            $query->where('start_date', '<', $endTime)
                ->where('end_date', '>', $startTime);
        })
        ->exists();

    // VERROU 2 : On vérifie aussi si le vélo lui-même n'est pas en maintenance
    if ($bike->status !== 'available') {
        return response()->json([
            'available' => false,
            'message' => 'Ce vélo est actuellement en maintenance.'
        ]);
    }

    return response()->json([
        'available' => !$isBooked,
        'total_price' => (float) $price,
        'label' => $label,
        'message' => !$isBooked ? 'Disponible' : 'Ce créneau est déjà réservé'
    ]);
    }

    public function confirmBooking(Request $request)
    {
        // 1. Validation stricte des données entrantes
        $request->validate([
            'bike_id' => 'required|exists:bikes,id',
            'date' => 'required|date|after_or_equal:today',
            'type' => 'required|in:morning,afternoon,full_day',
        ]);

        return DB::transaction(function () use ($request) {
            $bike = Bike::find($request->bike_id);
            $date = $request->date;
            $type = $request->type;

            // 2. Définition des horaires (doit correspondre à la logique du check)
            if ($type == 'morning') {
                $start = "$date 09:00:00";
                $end = "$date 13:00:00";
                $price = $bike->price_morning;
            } elseif ($type == 'afternoon') {
                $start = "$date 13:30:00";
                $end = "$date 17:30:00";
                $price = $bike->price_afternoon;
            } else {
                $start = "$date 09:00:00";
                $end = "$date 17:30:00";
                $price = $bike->price_full_day;
            }

            // 3. DOUBLE VÉRIFICATION (Sécurité anti-doublon au moment de l'écriture)
            $isBooked = Booking::where('bike_id', $bike->id)
                ->where('status', '!=', 'cancelled')
                ->where(function ($query) use ($start, $end) {
                    $query->where('start_date', '<', $end)
                        ->where('end_date', '>', $start);
                })
                // "lockForUpdate" empêche une autre requête de lire cette ligne 
                // tant que la transaction n'est pas finie
                ->lockForUpdate()
                ->exists();

            if ($isBooked) {
                return response()->json(['message' => 'Désolé, ce créneau vient d\'être réservé.'], 422);
            }

            // 4. Création de la réservation avec votre format de référence
            $booking = Booking::create([
                'user_id' => auth()->id() ?? 1, // Utilise l'admin par défaut si non connecté pour le test
                'bike_id' => $bike->id,
                'start_date' => $start,
                'end_date' => $end,
                'total_price' => $price,
                'reference' => 'MILLY-' . strtoupper(Str::random(10)), // Format vu dans votre SQL
                'status' => 'pending',
                'payment_status' => 'unpaid',
            ]);

            return response()->json([
                'message' => 'Réservation créée avec succès !',
                'booking' => $booking,
                'redirect_url' => route('payment.index', ['reference' => $booking->reference])
            ]);
        });
    }
}