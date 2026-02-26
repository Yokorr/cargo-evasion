<!DOCTYPE html>
<html>
<body style="font-family: sans-serif; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; border: 2px solid #10b981; padding: 20px; border-radius: 10px;">
        <h1 style="color: #10b981; text-align: center;">🎉 BRAVO !</h1>
        <p style="text-align: center; font-size: 18px;">Une nouvelle réservation vient d'être enregistrée.</p>
        
        <div style="background: #f3f4f6; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <h3 style="margin-top: 0;">👤 Client</h3>
            <p><strong>Nom :</strong> {{ $bookings->first()->user->name }}</p>
            <p><strong>Email :</strong> {{ $bookings->first()->user->email }}</p>
            <p><strong>Référence :</strong> <span style="color: #10b981; font-weight: bold;">{{ $reference }}</span></p>
        </div>

        <h3>🚲 Matériel réservé</h3>
        <ul>
            @foreach($bookings as $booking)
                <li>
                    <strong>{{ $booking->bike->model }}</strong> - 
                    Du {{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y H:i') }} 
                    au {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y H:i') }}
                </li>
            @endforeach
        </ul>

        <p style="font-size: 18px;"><strong>Total :</strong> {{ $bookings->sum('total_price') }} €</p>
        <p><strong>Mode de paiement :</strong> {{ strtoupper($bookings->first()->payment_method) }}</p>

        <div style="text-align: center; margin-top: 30px;">
            <a href="https://votre-site.com/admin/reservations" style="background: #000; color: #fff; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">Voir dans l'interface Admin</a>
        </div>
    </div>
</body>
</html>