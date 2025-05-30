<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade; // <-- Aquí importas Blade
use Carbon\Carbon;
class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
       Carbon::setLocale('es');
       
    }

    public function register()
    {
        //
    }
}
