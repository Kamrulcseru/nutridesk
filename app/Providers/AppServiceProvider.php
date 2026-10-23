<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        if (
            (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
            || request()->server('HTTP_X_FORWARDED_PROTO') === 'https'
            || str_contains(request()->getHost(), 'trycloudflare.com')
            || str_contains(request()->getHost(), 'loca.lt')
        ) {
            URL::forceScheme('https');
        }
    }
}
