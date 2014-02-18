<?php

namespace Toiee\haik\Providers;

use Illuminate\Support\Facades\Facade;

class ParserFacade extends Facade {
    
    protected static function getFacadeAccessor()
    {
        return 'parser';
    }
}