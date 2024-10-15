<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class MyDate extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mydate';
    }
}
