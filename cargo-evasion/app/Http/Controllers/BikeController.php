<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use Illuminate\Http\Request;

class BikeController extends Controller
{
    public function index()
    {
        $bikes = Bike::where('status', 'available')
            ->with(['prices', 'bookings' => function($query) {
                $query->where('end_date', '>=', now())
                    ->where('payment_status', 'paid')
                    ->orderBy('start_date', 'asc');
            }])
            ->get();

        return view('bikes.index', compact('bikes'));
    }
}
