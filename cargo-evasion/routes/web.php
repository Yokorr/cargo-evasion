<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Bike;
use App\Http\Controllers\Admin\AdminBikeController;
use App\Http\Controllers\Admin\AdminDailyCodeController;
use App\Http\Controllers\BikeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    $availableBikesCount = Bike::where('status', 'available')->count();
    return view('welcome', [
        'availableBikesCount' => $availableBikesCount
    ]);
});

Route::get('/nos-velos', [BikeController::class, 'index'])->name('bikes.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/velos', [AdminBikeController::class, 'index'])->name('admin.bikes.index');
    
    Route::get('/velos/creer', [AdminBikeController::class, 'create'])->name('admin.bikes.create');
    Route::post('/velos', [AdminBikeController::class, 'store'])->name('admin.bikes.store');
    Route::patch('/velos/{bike}/status', [AdminBikeController::class, 'updateStatus'])->name('admin.bikes.updateStatus');
    
    Route::get('/codes', [AdminDailyCodeController::class, 'index'])->name('admin.codes.index');
    Route::post('/codes', [AdminDailyCodeController::class, 'store'])->name('admin.codes.store');

    Route::post('/velos/{bike}/prices', [AdminBikeController::class, 'storePrice'])->name('admin.bikes.storePrice');
    
});

Route::post('/bookings/check-availability', [BookingController::class, 'check'])->name('bookings.check');


// Gestion de la sélection (Panier)
Route::post('/selection/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/recapitulatif', [CartController::class, 'index'])->name('cart.index');
Route::delete('/selection/{id}', [CartController::class, 'remove'])->name('cart.remove');