<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;


Route::view('/', 'home')->name('home');

// Admin routes with prefix (no auth required - for testing)
Route::prefix('admin')->group(function () {
    Route::view('dashboard', 'admin.dashboard')->name('admin.dashboard');
    
    // Admin's personal profile (single profile)
    Route::get('profile', [ProfileController::class, 'show'])->name('admin.profile.show');
    Route::get('profile/create', [ProfileController::class, 'create'])->name('admin.profile.create');
    Route::post('profile', [ProfileController::class, 'store'])->name('admin.profile.store');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::get('profile/image', [ProfileController::class, 'showImage'])->name('admin.profile.image');
});

// Regular dashboard route (no auth for now)
Route::view('dashboard', 'admin.dashboard')->name('dashboard');

// Auth routes (still available for future use)
require __DIR__.'/auth.php';