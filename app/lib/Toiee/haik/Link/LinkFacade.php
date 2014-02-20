<?php

namespace Toiee\haik\Link;

use Illuminate\Support\Facades\Facade;

class LinkFacade extends Facade {
    
    protected static function getFacadeAccessor()
    {
        return 'link';
    }
}