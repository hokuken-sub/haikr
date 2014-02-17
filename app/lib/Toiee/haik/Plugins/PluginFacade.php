<?php

namespace Toiee\haik\Plugins;

use Illuminate\Support\Facades\Facade;

class PluginFacade extends Facade {
    
    protected static function getFacadeAccessor()
    {
        return 'plugin';
    }
}