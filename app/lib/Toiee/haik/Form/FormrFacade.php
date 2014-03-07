<?php
namespace Toiee\haik\Form;

use Illuminate\Support\Facades\Facade;

class FormrFacade extends Facade {
    
    protected static function getFacadeAccessor()
    {
        return 'formr';
    }
}
