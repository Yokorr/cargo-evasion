<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id', 'bike_id', 'start_date', 'end_date', 
        'total_price', 'payment_status', 'monetico_token', 'code_date'
    ];

    // Une réservation appartient à un utilisateur
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Une réservation appartient à un vélo
    public function bike() {
        return $this->belongsTo(Bike::class);
    }
}
