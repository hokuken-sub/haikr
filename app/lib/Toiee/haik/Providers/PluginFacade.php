<?php

namespace Toiee\haik\Providers;

use Illuminate\Support\Facades\Facade;

class PluginFacade extends Facade {
    
    protected static function getFacadeAccessor()
    {
        return 'plugin';
    }
}