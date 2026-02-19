<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bike;

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
        // 1. On récupère le panier actuel ou un tableau vide
        $cart = session()->get('cart', []);

        // 2. On récupère les infos du vélo pour avoir le nom propre
        $bike = Bike::find($request->bike_id);

        // 3. On ajoute le nouvel article
        $cart[] = [
            'id' => uniqid(), // ID unique pour pouvoir le supprimer plus tard
            'bike_id' => $request->bike_id,
            'model' => $bike->model,
            'price' => $request->total_price,
            'label' => $request->label,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];

        // 4. On sauvegarde dans la session
        session()->put('cart', $cart);

        // 5. On renvoie un JSON de succès
        return response()->json(['success' => true]);
    }
}