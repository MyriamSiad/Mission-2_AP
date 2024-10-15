<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\MyApp\PdoGsb;
class MyPdoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('pdogsb', function ($app) {
            return new PdoGsb();
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
