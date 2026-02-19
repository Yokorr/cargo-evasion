<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- AJOUTÉ
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function process()
    {
        // 1. Vérification de la session
        $reference = session('order_reference');
        $amount = session('order_total');
        
        // Sécurité : Si pas de référence ou pas connecté, on dégage au panier
        if (!$reference || !Auth::check()) {
            return redirect()->route('cart.index');
        }

        $email = Auth::user()->email;

        // 2. Paramètres Monetico
        $params = [
            'TPE' => env('MONETICO_TPE'),
            'contexteVente' => 'Ecommerce',
            'date' => Carbon::now()->format('d/m/Y:H:i:s'),
            'montant' => $amount . 'EUR',
            'reference' => $reference,
            'texte-libre' => 'Location de vélos - Milly Évasion',
            'version' => '3.0',
            'codeSociete' => env('MONETICO_CODE_SOCIETE'),
            'mail' => $email,
            'url_retour_ok' => route('payment.success'),
            'url_retour_err' => route('payment.error'),
        ];

        $params['MAC'] = $this->generateMac($params);

        return view('payment.redirect', [
            'url' => env('MONETICO_URL'),
            'params' => $params
        ]);
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

    public function success() { return view('payment.success'); }
    public function error() { return view('payment.error'); }
}