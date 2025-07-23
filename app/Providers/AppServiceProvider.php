<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use App\Models\Profile;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production (Heroku-compatible)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Share profile data with all views
        View::composer('*', function ($view) {
            $profile = Profile::first();
            $view->with('profile', $profile);
        });
    }
}
