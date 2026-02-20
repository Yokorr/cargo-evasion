<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bike;
use App\Models\Booking;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum('price');
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        // 1. Traduction des données JS (date + type) en horaires réels
        $date = $request->input('date'); // YYYY-MM-DD
        $type = $request->input('type'); // morning, afternoon, full_day
        $bikeId = $request->input('bike_id');

        // Définition des heures selon le créneau Milly Évasion
        if ($type === 'morning') {
            $start = $date . ' 09:00:00';
            $end   = $date . ' 13:00:00';
        } elseif ($type === 'afternoon') {
            $start = $date . ' 13:30:00';
            $end   = $date . ' 17:30:00';
        } else { // full_day
            $start = $date . ' 09:00:00';
            $end   = $date . ' 17:30:00';
        }

        // 2. VÉRIFICATION DE DISPONIBILITÉ
        if (!Booking::isAvailable($bikeId, $start, $end)) {
            return response()->json([
                'success' => false,
                'message' => 'Ce vélo vient d\'être réservé par quelqu\'un d\'autre.'
            ], 422); // Erreur de validation
        }

        // 3. Récupération des infos du vélo pour le prix et le nom
        $bike = Bike::find($bikeId);
        if (!$bike) {
            return response()->json(['success' => false, 'message' => 'Vélo introuvable.'], 404);
        }

        // Calcul du prix selon le créneau
        $price = $bike->price_full_day;
        if($type === 'morning') $price = $bike->price_morning;
        if($type === 'afternoon') $price = $bike->price_afternoon;

        // 4. Gestion du Panier en Session
        $cart = session()->get('cart', []);
        
        $cart[] = [
            'id' => uniqid(),
            'bike_id' => $bikeId,
            'model' => $bike->model,
            'price' => $price,
            'type_label' => ($type === 'morning' ? 'Matinée' : ($type === 'afternoon' ? 'Après-midi' : 'Journée complète')),
            'start_date' => $start,
            'end_date' => $end,
        ];

        session()->put('cart', $cart);

        // 5. Réponse JSON (indispensable pour Alpine.js)
        return response()->json([
            'success' => true,
            'message' => 'Vélo ajouté !',
            'redirect' => route('cart.index')
        ]);
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        $cart = array_filter($cart, fn($item) => $item['id'] !== $id);
        session()->put('cart', $cart);
        return back()->with('success', 'Vélo retiré du panier.');
    }
}