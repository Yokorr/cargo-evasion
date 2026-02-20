<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- AJOUTÉ
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function process()
    {
        $reference = session('order_reference');
        $amount = session('order_total');
        $method = session('payment_method', 'monetico'); // On récupère le choix du client

        if (!$reference || !Auth::check()) {
            return redirect()->route('cart.index');
        }

        // --- CAS 1 : PAIEMENT EN LIGNE (MONETICO) ---
        if ($method === 'monetico') {
            $params = [
                'TPE' => env('MONETICO_TPE'),
                'contexteVente' => 'Ecommerce',
                'date' => Carbon::now()->format('d/m/Y:H:i:s'),
                'montant' => $amount . 'EUR',
                'reference' => $reference,
                'texte-libre' => 'Location de vélos - Milly Évasion',
                'version' => '3.0',
                'codeSociete' => env('MONETICO_CODE_SOCIETE'),
                'mail' => Auth::user()->email,
                'url_retour_ok' => route('payment.success'),
                'url_retour_err' => route('payment.error'),
            ];
            $params['MAC'] = $this->generateMac($params);

            return view('payment.redirect', ['url' => env('MONETICO_URL'), 'params' => $params]);
        }

        // --- CAS 2 : PAIEMENT EN LIGNE (PAYPAL) ---
        if ($method === 'paypal') {
            // Ici, je ferais la logique PayPal plus tard
            return redirect()->route('payment.paypal.process'); 
        }

        // --- CAS 3 : PAIEMENT HORS-LIGNE (ESPÈCES / CHÈQUE) ---
        if (in_array($method, ['cash', 'check'])) {
            // On pourrait mettre à jour le statut ici
            // $booking = Booking::where('reference', $reference)->update(['payment_status' => 'waiting_on_site']);
            
            return redirect()->route('payment.success')->with('offline_payment', true);
        }

        return redirect()->route('payment.error');
    }

    private function generateMac($params)
    {
        $key = env('MONETICO_CLE_SECURITE');
        
        $data = implode('*', [
            $params['TPE'],
            $params['date'],
            $params['montant'],
            $params['reference'],
            $params['texte-libre'],
            $params['version'],
            'FR', 
            $params['codeSociete'],
            '', '', '' 
        ]);

        return strtolower(hash_hmac('sha1', $data, pack('H*', $key)));
    }

    public function success()
    {
        $reference = session('order_reference');
        $method = session('payment_method');
        $total = session('order_total');

        // Si on arrive ici sans session, on redirige vers l'accueil
        if (!$reference) {
            return redirect('/');
        }

        return view('payment.success', compact('reference', 'method', 'total'));
    }
    public function error() 
    { 
        // On peut récupérer la référence en session pour l'afficher
        $reference = session('order_reference');
        return view('payment.error', compact('reference')); 
    }
}