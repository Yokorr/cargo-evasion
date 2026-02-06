<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $cart = session()->get('cart', []);

        // On récupère les infos du vélo et du calcul de prix
        $bike = Bike::find($request->bike_id);
        
        // On ajoute à la session
        $cart[] = [
            'id' => uniqid(), // ID unique pour le panier
            'bike_id' => $bike->id,
            'model' => $bike->model,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'price' => $request->total_price,
            'label' => $request->label
        ];

        session()->put('cart', $cart);

        return response()->json(['message' => 'Ajouté à la sélection', 'count' => count($cart)]);
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        $total = array_sum(array_column($cart, 'price'));

        return view('cart.index', compact('cart', 'total'));
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        $cart = array_filter($cart, fn($item) => $item['id'] !== $id);
        session()->put('cart', $cart);

        return back()->with('success', 'Vélo retiré');
    }
}
