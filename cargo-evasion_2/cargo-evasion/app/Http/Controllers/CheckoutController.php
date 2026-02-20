<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking; // <-- AJOUTÉ : Pour que le contrôleur connaisse la table Booking
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
        // 1. Validation (Ajout du mode de paiement et du mot de passe pour les guests)
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'payment_method' => 'required|in:monetico,paypal,cash,check', // Validation du choix
            'password' => Auth::check() ? 'nullable' : 'required|confirmed|min:8', // Validation MDP si guest
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

        $orderReference = 'MILLY-' . strtoupper(Str::random(8)); // Référence un peu plus courte et propre
        $totalAmount = array_sum(array_column($cart, 'price'));

        // VÉRIFICATION DE SÉCURITÉ AVANT CRÉATIN
        foreach ($cart as $item) {
            if (!Booking::isAvailable($item['bike_id'], $item['start_date'], $item['end_date'])) {
                return redirect()->route('cart.index')->with('error', "Désolé, le vélo {$item['model']} n'est plus disponible pour ces dates. Quelqu'un a été plus rapide !");
            }
        }

        // 3. Enregistrement en base
        foreach ($cart as $index => $item) {
            Booking::create([
                'user_id' => $user->id,
                'bike_id' => $item['bike_id'],
                'start_date' => $item['start_date'],
                'end_date' => $item['end_date'],
                'total_price' => $item['price'],
                'reference' => $orderReference . '-'. ($index + 1),
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'payment_method' => $request->payment_method, // On garde une trace du mode choisi
            ]);
        }

        // 4. Session & Redirection (Ajout de payment_method en session)
        session()->put('order_reference', $orderReference);
        session()->put('order_total', $totalAmount);
        session()->put('payment_method', $request->payment_method); // pour le PaymentController
        
        session()->forget('cart');
        session()->save();

        return redirect()->route('payment.process');
    }
}