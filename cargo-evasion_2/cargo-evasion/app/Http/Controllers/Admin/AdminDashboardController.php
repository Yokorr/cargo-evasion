<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Bike;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'bookings_today' => Booking::whereDate('created_at', Carbon::today())->count(),
            'total_revenue'  => Booking::where('payment_status', 'paid')->sum('total_price'),
            'available_bikes'=> Bike::where('status', 'available')->count(),
            'active_rentals' => Booking::where('status', 'confirmed')
                                       ->whereDate('start_date', '<=', Carbon::today())
                                       ->whereDate('end_date', '>=', Carbon::today())
                                       ->count(),
        ];

        // On prend les 5 dernières réservations pour le tableau
        $recentBookings = Booking::with(['user', 'bike'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentBookings'));
    }
}