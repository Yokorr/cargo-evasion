<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


use App\Http\Controllers\Admin\AdminBikeController;
use App\Http\Controllers\Admin\AdminDailyCodeController;

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/velos', [AdminBikeController::class, 'index'])->name('admin.bikes.index');
    // Nouvelles routes pour la création
    Route::get('/velos/creer', [AdminBikeController::class, 'create'])->name('admin.bikes.create');
    Route::post('/velos', [AdminBikeController::class, 'store'])->name('admin.bikes.store');
    Route::patch('/velos/{bike}/status', [AdminBikeController::class, 'updateStatus'])->name('admin.bikes.updateStatus');
    
    Route::get('/codes', [AdminDailyCodeController::class, 'index'])->name('admin.codes.index');
    Route::post('/codes', [AdminDailyCodeController::class, 'store'])->name('admin.codes.store');
    
});
