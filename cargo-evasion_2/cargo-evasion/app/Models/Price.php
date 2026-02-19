<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = ['bike_id', 'label', 'amount', 'duration_hours'];

    public function bike() {
        return $this->belongsTo(Bike::class);
    }
}
