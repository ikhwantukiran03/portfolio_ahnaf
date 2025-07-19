<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::view('/', 'home')->name('home');

// Admin routes with prefix (no auth for now)
Route::prefix('admin')->group(function () {
    Route::view('dashboard', 'admin.dashboard')->name('admin.dashboard');
    Route::resource('profiles', ProfileController::class);
    Route::get('profiles/{profile}/image', [ProfileController::class, 'showImage'])->name('profiles.image');
});

// Regular dashboard route (no auth for now)
Route::view('dashboard', 'admin.dashboard')->name('dashboard');

// Profile route (keeping auth for user profile management)
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';