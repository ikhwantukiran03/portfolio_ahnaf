<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\ResumeController;

// Public routes
Route::view('/', 'home')->name('home');
Route::get('/resume', [ResumeController::class, 'index'])->name('resume');

// Admin routes with prefix (no auth required - for testing)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::view('dashboard', 'admin.dashboard')->name('dashboard');
    
    // Admin's personal profile (single profile)
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/create', [ProfileController::class, 'create'])->name('profile.create');
    Route::post('profile', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile/image', [ProfileController::class, 'showImage'])->name('profile.image');

    // Services management
    Route::resource('services', ServiceController::class);
    Route::post('services/update-order', [ServiceController::class, 'updateOrder'])->name('services.updateOrder');

    // Experiences management
    Route::resource('experiences', ExperienceController::class);
    Route::post('experiences/update-order', [ExperienceController::class, 'updateOrder'])->name('experiences.updateOrder');

    // Certificates management
    Route::resource('certificates', CertificateController::class);
    Route::get('certificates/{certificate}/file', [CertificateController::class, 'showFile'])->name('certificates.show-file');
    Route::post('certificates/update-order', [CertificateController::class, 'updateOrder'])->name('certificates.update-order');
});

// Regular dashboard route (no auth for now)
Route::view('dashboard', 'admin.dashboard')->name('dashboard');

// Auth routes (still available for future use)
require __DIR__.'/auth.php';