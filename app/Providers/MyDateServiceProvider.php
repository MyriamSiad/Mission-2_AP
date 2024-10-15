<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\MyApp\MyDate;
class MyDateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('mydate', function ($app) {
            return new MyDate();
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
