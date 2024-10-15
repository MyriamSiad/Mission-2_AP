<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\MyApp\MyApp;
class MyAppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('myapp', function ($app) {
            return new MyApp();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
