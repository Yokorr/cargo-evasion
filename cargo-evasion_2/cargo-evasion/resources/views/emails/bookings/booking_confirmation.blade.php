<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; }
        .header { background: #000; color: #fff; padding: 20px; text-align: center; font-weight: bold; font-size: 24px; }
        .content { padding: 20px; }
        .footer { font-size: 12px; color: #888; text-align: center; margin-top: 20px; }
        .ref { font-weight: bold; color: #10b981; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">MILLY ÉVASION</div>
        <div class="content">
            <p>Bonjour {{ $bookings->first()->user->name }},</p>
            <p>Bonne nouvelle ! Votre paiement a été validé avec succès.</p>
            <p>Votre référence de commande est : <span class="ref">{{ $reference }}</span></p>
            
            <h3>Détails de votre réservation :</h3>
            <ul>
                @foreach($bookings as $booking)
                    <li>
                        <strong>{{ $booking->bike->model }}</strong><br>
                        Du {{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y H:i') }} 
                        au {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y H:i') }}
                    </li>
                @endforeach
            </ul>

            <p><strong>Total payé :</strong> {{ $bookings->sum('total_price') }} €</p>
            
            <hr>
            <p>Un autre e-mail vous sera envoyé prochainement avec votre <strong>code de retrait</strong> pour accéder à vos vélos.</p>
            <p>À très bientôt pour votre balade !</p>
        </div>
        <div class="footer">
            Milly Évasion - Location de vélos à Milly-la-Forêt<br>
            Ceci est un message automatique, merci de ne pas y répondre.
        </div>
    </div>
</body>
</html>