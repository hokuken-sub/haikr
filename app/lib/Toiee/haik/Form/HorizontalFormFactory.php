<?php
namespace Toiee\haik\Form;

use Toiee\haik\Form\FormFactoryInterface;

class HorizontalFormFactory implements FormFactoryInterface {

    protected $type;

    protected $reserved = array('text', 'email', 'textarea', 'checkbox', 'radio', 'select', 'hidden', 'file', 'agree');

    /**
    * Create a new form factory.
    *
    * @param  string  $type
    * @return void
    */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * Return form parts 
     *
     * @param  string $type form parts type
     * @param  array  $options form data
     * @return FormPart form parts
     */
    public function factory($type, $options = array())
    {
        $class = '\Toiee\haik\Form\Parts\\'.camel_case($type);
        return new $class($this->type, $options);
    }

    /**
     * Return parts array
     *
     * @return array parts able to use form
     */
    public function parts()
    {
        return $this->reserved;
    }

}
