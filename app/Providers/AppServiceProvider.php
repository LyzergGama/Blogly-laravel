<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Set default string length for database schema
        Schema::defaultStringLength(191);

        // Share data with all views if needed
        // View::share('key', 'value');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register any application services here
    }
}
