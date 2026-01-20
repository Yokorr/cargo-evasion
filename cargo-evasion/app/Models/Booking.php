<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function bike() {
        return $this->belongsTo(Bike::class);
    }
}
