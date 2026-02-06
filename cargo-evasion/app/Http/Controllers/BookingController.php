<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    
public function check(Request $request)
{
    $bike = Bike::find($request->bike_id);
    
    // On récupère le créneau envoyé par le bouton cliqué (morning, afternoon ou full_day)
    // On peut se baser sur les heures ou plus simplement sur un paramètre "type" envoyé par le bouton
    $type = $request->type; 

    $price = 0;
    $label = "";

    if ($type == 'morning') {
        $price = $bike->price_morning;
        $label = "Matinée (9h-13h)";
    } elseif ($type == 'afternoon') {
        $price = $bike->price_afternoon;
        $label = "Après-midi (13h30-17h30)";
    } else {
        $price = $bike->price_full_day;
        $label = "Journée complète";
    }

    return response()->json([
        'available' => true,
        'total_price' => $price,
        'label' => $label
    ]);
}
}
