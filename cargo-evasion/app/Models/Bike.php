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
}
