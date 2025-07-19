<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::view('/', 'home')->name('home');

Route::view('dashboard', 'dashboard')
    
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Profile CRUD routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('profiles', ProfileController::class);
    Route::get('profiles/{profile}/image', [ProfileController::class, 'showImage'])->name('profiles.image');
});

require __DIR__.'/auth.php';