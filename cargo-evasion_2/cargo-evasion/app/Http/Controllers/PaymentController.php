<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail; 
use App\Mail\BookingConfirmation;      
use Carbon\Carbon;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Booking;
use App\Mail\StaffBookingNotification;

class PaymentController extends Controller
{
    public function process()
    {
        $reference = session('order_reference');
        $amount = number_format(session('order_total'), 2, '.', ''); 
        $method = session('payment_method', 'monetico');

        if (!$reference || !Auth::check()) {
            return redirect()->route('cart.index')->with('error', 'Session expirée.');
        }

        if ($method === 'monetico') {
            $params = [
                'TPE'            => env('MONETICO_TPE'),
                'contexteVente'  => 'Ecommerce',
                'date'           => Carbon::now()->format('d/m/Y:H:i:s'),
                'montant'        => $amount . 'EUR',
                'reference'      => $reference,
                'texte-libre'    => 'Location Milly Evasion',
                'version'        => '3.0',
                'codeSociete'    => env('MONETICO_CODE_SOCIETE'),
                'lgue'           => 'FR',
                'mail'           => Auth::user()->email,
                'url_retour_ok'  => route('payment.success'),
                'url_retour_err' => route('payment.error'),
            ];
            
            $params['MAC'] = $this->generateMac($params);
            return view('payment.redirect', ['url' => env('MONETICO_URL'), 'params' => $params]);
        }

        if ($method === 'paypal') {
            return $this->processPayPal($amount, $reference);
        }

        // --- CAS 3 : PAIEMENT HORS-LIGNE (Espèces/Chèque) ---
        if (in_array($method, ['cash', 'check'])) {
            
            $this->updateBookingStatus($reference, 'pending', 'unpaid', $method);
            $this->sendConfirmationEmail($reference);
            return redirect()->route('payment.success');
        }

        return redirect()->route('payment.error');
    }

    public function notify(Request $request)
    {
        $data = $request->all();
        $reference = $data['reference'] ?? null;
        $computedMac = $this->generateMac($data);
        
        if (isset($data['MAC']) && $data['MAC'] === $computedMac) {
            if (in_array($data['code-retour'], ['paye', 'paiement'])) {
                
                // 1. Mise à jour BDD
                $this->updateBookingStatus($reference, 'confirmed', 'paid', 'monetico');
                
                // 2. Envoi du mail (AVANT le return)
                $this->sendConfirmationEmail($reference);
                
                // 3. Réponse à la banque
                return response("version=2\nresult=0\n", 200)->header('Content-Type', 'text/plain');
            }
        }

        return response("version=2\nresult=1\n", 200)->header('Content-Type', 'text/plain');
    }

    public function success(Request $request)
    {
        $reference = session('order_reference');
        $method = session('payment_method');
        $total = session('order_total');

        if (!$reference) return redirect('/');

        // On ne traite ICI que le cas PayPal (car c'est le retour direct après capture)
        if ($method === 'paypal' && $request->has('token')) {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();
            $response = $provider->capturePaymentOrder($request->token);

            if (isset($response['status']) && $response['status'] === 'COMPLETED') {
                $this->updateBookingStatus($reference, 'confirmed', 'paid', 'paypal');
                $this->sendConfirmationEmail($reference);
            } else {
                return redirect()->route('payment.error')->with('error', 'Échec capture PayPal.');
            }
        }
        // On vide la session
        session()->forget(['cart', 'order_reference', 'order_total', 'payment_method']);

        return view('payment.success', compact('reference', 'method', 'total'));
    }

    /**
     * Helper pour centraliser la mise à jour des statuts
     */
    private function updateBookingStatus($reference, $status, $paymentStatus, $method)
    {
        return DB::table('bookings')
            ->where('reference', 'LIKE', $reference . '%') 
            ->update([
                'status'         => $status,
                'payment_status' => $paymentStatus,
                'payment_method' => $method,
                'updated_at'     => now(),
            ]);
    }

    private function sendConfirmationEmail($reference)
    {
        try {
            $bookings = Booking::where('reference', 'LIKE', $reference . '%')
                            ->with(['user', 'bike'])
                            ->get();

            if ($bookings->count() > 0) {
                $user = $bookings->first()->user;

                // 1. Mail pour le Client
                Mail::to($user->email)->send(new BookingConfirmation($bookings, $reference));

                // 2. Mail pour le Staff (Remplace par l'email de ton équipe)
                $staffEmail = "contact@location-velos-milly91.com"; 
                Mail::to($staffEmail)->send(new StaffBookingNotification($bookings, $reference));

                Log::info("Mails (Client + Staff) envoyés pour la réf : " . $reference);
            }
        } catch (\Exception $e) {
            Log::error("Erreur envoi mails : " . $e->getMessage());
        }
    }

    
    private function processPayPal($amount, $reference)
    {
        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "purchase_units" => [["reference_id" => $reference, "amount" => ["currency_code" => "EUR", "value" => $amount]]],
                "application_context" => ["cancel_url" => route('payment.error'), "return_url" => route('payment.success')]
            ]);
            if (isset($response['id'])) {
                foreach ($response['links'] as $link) { if ($link['rel'] == 'approve') return redirect()->away($link['href']); }
            }
            return redirect()->route('payment.error');
        } catch (\Exception $e) { return redirect()->route('payment.error'); }
    }

    private function generateMac($params)
    {
        $key = env('MONETICO_CLE_SECURITE');
        $data = implode('*', [
            $params['TPE'], $params['date'], $params['montant'], $params['reference'],
            $params['texte-libre'], $params['version'], $params['lgue'] ?? 'FR',
            $params['codeSociete'], '', '', ''
        ]);
        return strtolower(hash_hmac('sha1', $data, pack('H*', $key)));
    }

    public function error() { return view('payment.error', ['reference' => session('order_reference')]); }
}