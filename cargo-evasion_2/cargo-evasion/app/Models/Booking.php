<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'bike_id', 'start_date', 'end_date', 'total_price', 'reference', 'status', 'payment_status'
    ];

    // Relation : Une réservation appartient à UN utilisateur
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relation : Une réservation appartient à UN vélo
    public function bike(): BelongsTo
    {
        return $this->belongsTo(Bike::class);
    }
}