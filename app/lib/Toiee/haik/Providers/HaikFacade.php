<?php

namespace Toiee\haik\Providers;

use Illuminate\Support\Facades\Facade;

class HaikFacade extends Facade {
    
    protected static function getFacadeAccessor()
    {
        return 'haik';
    }
}