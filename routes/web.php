<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\SocialContactController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\ContactController;

// Public routes
Route::view('/', 'home')->name('home');
Route::get('/resume', [ResumeController::class, 'index'])->name('resume');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Public API route for social contacts
Route::get('/api/social-contacts', [SocialContactController::class, 'getPublicContacts'])->name('api.social-contacts');

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

    // Social Contacts management
    Route::resource('social-contacts', SocialContactController::class);
    Route::post('social-contacts/update-order', [SocialContactController::class, 'updateOrder'])->name('social-contacts.update-order');
    Route::post('social-contacts/{socialContact}/toggle-primary', [SocialContactController::class, 'togglePrimary'])->name('social-contacts.toggle-primary');
    Route::post('social-contacts/{socialContact}/toggle-public', [SocialContactController::class, 'togglePublic'])->name('social-contacts.toggle-public');

    Route::resource('portfolios', \App\Http\Controllers\Admin\PortfolioController::class);
    Route::get('portfolios/{portfolio}/file', [\App\Http\Controllers\Admin\PortfolioController::class, 'showFile'])->name('portfolios.show-file');
});

// Regular dashboard route (no auth for now)
Route::view('dashboard', 'admin.dashboard')->name('dashboard');

// Auth routes (still available for future use)
require __DIR__.'/auth.php';