<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // Ensure this line is imported!

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
        // Forces Laravel to serve compiled Vite & Tailwind assets over secure HTTPS when live on Render
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}