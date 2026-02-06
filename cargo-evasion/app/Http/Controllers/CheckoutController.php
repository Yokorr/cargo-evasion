<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking; // <-- AJOUTÉ : Pour que le contrôleur connaisse la table Booking
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect()->route('bikes.index');
        
        $total = array_sum(array_column($cart, 'price'));
        return view('checkout.index', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        // 1. Validation
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
        ]);

        // 2. Gestion Utilisateur
        if (!Auth::check()) {
            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
            ]);
            Auth::login($user);
        }

        $user = Auth::user();
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('bikes.index')->with('error', 'Votre panier est vide.');
        }

        $orderReference = 'MILLY-' . strtoupper(uniqid());
        $totalAmount = array_sum(array_column($cart, 'price'));

        // 3. Enregistrement en base
        foreach ($cart as $item) {
            Booking::create([ // <-- Utilisation directe de Booking car importé en haut
                'user_id' => $user->id,
                'bike_id' => $item['bike_id'],
                'start_date' => $item['start_date'],
                'end_date' => $item['end_date'],
                'total_price' => $item['price'],
                'reference' => $orderReference,
                'status' => 'pending',
                'payment_status' => 'unpaid',
            ]);
        }

        // 4. Session & Redirection
        session()->put('order_reference', $orderReference);
        session()->put('order_total', $totalAmount);
        
        session()->forget('cart');
        session()->save(); // On force l'enregistrement ici

        return redirect()->route('payment.process');
    }
}