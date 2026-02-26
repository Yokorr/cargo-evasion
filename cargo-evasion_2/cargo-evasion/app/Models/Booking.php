<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Booking extends Model
{
    
    protected $fillable = [
        'user_id', 'bike_id', 'start_date', 'end_date', 'total_price', 'reference', 'status', 'payment_status','payment_method'
    ];


    public static function isAvailable($bikeId, $start, $end)
    {
        // On convertit en format SQL pour être sûr que la base de données comprenne
        $start = Carbon::parse($start)->format('Y-m-d H:i:s');
        $end = Carbon::parse($end)->format('Y-m-d H:i:s');

        $conflict = self::where('bike_id', $bikeId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start, $end) {
                    $q->where('start_date', '<', $end)
                    ->where('end_date', '>', $start);
                });
            })
            ->exists();

        return !$conflict;
    }

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