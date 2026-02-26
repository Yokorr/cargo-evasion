<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'bike']);

        // 1. Recherche par nom ou référence (Groupée pour ne pas casser les autres filtres)
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('reference', 'LIKE', "%{$search}%")
                ->orWhereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('email', 'LIKE', "%{$search}%");
                });
            });
        }

        // 2. Filtre par statut (S'applique en plus de la recherche)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Pagination avec conservation des paramètres d'URL
        $bookings = $query->latest()->paginate(15)->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate(['status' => 'required|string']);
        
        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Statut de la réservation mis à jour.');
    }
}