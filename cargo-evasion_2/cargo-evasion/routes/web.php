<?php

use Illuminate\Support\Facades\Route;
use App\Models\Bike;

// Contrôleurs Front
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BikeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;

// Contrôleurs Admin
use App\Http\Controllers\Admin\AdminBikeController;
use App\Http\Controllers\Admin\AdminDailyCodeController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminDashboardController;
/*
|--------------------------------------------------------------------------
| 1. PAGES PUBLIQUES (FRONT-OFFICE)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    // On ne récupère que les vélos avec une image et un statut 'available'
    $availableBikes = \App\Models\Bike::where('status', 'available')
                        ->whereNotNull('image')
                        ->latest()
                        ->get();

    return view('welcome', [
        'availableBikesCount' => $availableBikes->count(),
        'availableBikes' => $availableBikes
    ]);
});

// La Flotte (Liste des vélos)
Route::get('/nos-velos', [BikeController::class, 'index'])->name('bikes.index');

/*
|--------------------------------------------------------------------------
| 2. TUNNEL DE RÉSERVATION (LOGIQUE JS & PANIER)
|--------------------------------------------------------------------------
*/

// Vérification de disponibilité (appelé par Alpine.js)
Route::post('/bookings/check', [BookingController::class, 'check'])->name('bookings.check');
Route::post('/bookings', [BookingController::class, 'confirmBooking'])->name('bookings.confirm');

// Gestion du Panier (Sélection)
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index'); // /cart
    Route::post('/add', [CartController::class, 'add'])->name('add');   // /cart/add
    Route::delete('/{id}', [CartController::class, 'remove'])->name('remove');
});

/*
|--------------------------------------------------------------------------
| 3. PAIEMENT & COMMANDES (CHECKOUT)
|--------------------------------------------------------------------------
*/
// Formulaire de coordonnées
Route::get('/finaliser-ma-reservation', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/finaliser-ma-reservation', [CheckoutController::class, 'store'])->name('checkout.store');

Route::post('/paiement/notify', [PaymentController::class, 'notify'])->name('payment.notify');

Route::middleware('auth')->group(function () {
    
    Route::prefix('paiement')->name('payment.')->group(function () {
        // 1. Les routes précises en PREMIER
        Route::get('/process', [PaymentController::class, 'process'])->name('process');
        Route::get('/succes', [PaymentController::class, 'success'])->name('success');
        Route::get('/erreur', [PaymentController::class, 'error'])->name('error');

        // 2. La route variable en DERNIER
        // On ajoute aussi une contrainte (where) pour être sûr que ça ne capture pas n'importe quoi
        Route::get('/{reference}', [PaymentController::class, 'process'])
              ->name('index')
              ->where('reference', 'MILLY-[A-Z0-9-]+'); 
    });
});

/*
|--------------------------------------------------------------------------
| 4. ESPACE CLIENT (PROFILE / DASHBOARD)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| 5. ESPACE ADMINISTRATION (PROTECTION ADMIN)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {


    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    // Gestion de la Flotte
    Route::get('/velos', [AdminBikeController::class, 'index'])->name('bikes.index');
    Route::get('/velos/creer', [AdminBikeController::class, 'create'])->name('bikes.create');
    Route::post('/velos', [AdminBikeController::class, 'store'])->name('bikes.store');
    Route::put('/velos/{bike}', [AdminBikeController::class, 'update'])->name('bikes.update');
    Route::get('/velos/{bike}/modifier', [AdminBikeController::class, 'edit'])->name('bikes.edit');
    
    // Codes Digicodes quotidiens
    Route::get('/codes', [AdminDailyCodeController::class, 'index'])->name('codes.index');
    Route::post('/codes', [AdminDailyCodeController::class, 'store'])->name('codes.store');

    // Gestion des Réservations
    Route::get('/reservations', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/reservations/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::patch('/reservations/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.updateStatus');

});