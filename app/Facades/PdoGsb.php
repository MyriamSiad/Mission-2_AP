<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class PdoGsb extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'pdogsb';
    }
}
