<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bike extends Model
{
    public function bookings() {
        return $this->hasMany(Booking::class);
    }
    // On autorise ces champs à être remplis via un formulaire
    protected $fillable = ['serial_number', 'model', 'status'];

    public function prices() {
        return $this->hasMany(Price::class);
    }

    public function isAvailable($start, $end)
    {
    // CONDITION 1 : Si le vélo est en maintenance, il est indisponible quoi qu'il arrive
    if ($this->status !== 'available') {
        return false;
    }

    // CONDITION 2 : On vérifie les chevauchements de réservations payées
    return !$this->bookings()
        ->where('payment_status', 'paid')
        ->where(function ($query) use ($start, $end) {
            $query->where('start_date', '<', $end)
                  ->where('end_date', '>', $start);
        })
        ->exists();

    }
}
