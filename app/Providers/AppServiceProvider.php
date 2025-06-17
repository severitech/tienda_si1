<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade; // <-- Aquí importas Blade
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Carbon::setLocale('es');
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }

    public function register()
    {
        //
    }
}
