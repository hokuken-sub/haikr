<?php
namespace Toiee\haik\File;

use Illuminate\Support\Facades\Facade;

class FileFacade extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'filr';
    }
}