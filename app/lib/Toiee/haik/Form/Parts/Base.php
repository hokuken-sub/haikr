<?php
namespace Toiee\haik\Form\Parts;

use Toiee\haik\Form\FormPartInterface;

abstract class Base implements FormPartInterface {

	/**
	 * The form type
	 *
	 * @var string
	 */
    protected $form_type;
    
	/**
	 * An array of form attributes
	 *
	 * @var array
	 */
    protected $attributes = array();

    /**
     * Return parts array
     *
     * return array parts detail
     */
    public function toArray()
    {
        return $this->attributes;
    }

    /**
     * Make part html 
     *
     * return string part html
     */
    public function render()
    {
        $classname = class_basename(get_called_class());
        $namespace = 'FormParts';
        $viewfile = $namespace . '::' . $this->form_type . '.parts.'. strtolower($classname);

        if ( ! \View::exists($viewfile))
        {
            $dirname = dirname(__DIR__) . '/views';
            \View::addLocation($dirname);
            \View::addNamespace($namespace, $dirname);
        }

        return \View::make($viewfile, $this->attributes)->render();
    }

}
