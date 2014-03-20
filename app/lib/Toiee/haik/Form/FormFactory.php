<?php
namespace Toiee\haik\Form;

class FormFactory implements FormFactoryInterface {

    protected $type;
    protected $parts_reserved = array();

    /**
    * Create a new form factory.
    *
    * @param  string $type form type
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
    public function partsFactory($type, $options = array())
    {
        $class = '\Toiee\haik\Form\Parts\\'.camel_case($type);
        return new $class($this->type, $options);
    }

    /**
     * Return form button 
     *
     * @param  string $type form parts type
     * @param  array  $options button data
     * @return Button
     */
    public function buttonFactory($options = array(), $action = 'confirm')
    {
        $class = '\Toiee\haik\Form\Button';
        return new $class($this->type, $options, $action);
    }

    /**
     * Return parts array
     *
     * @return array parts data for use form
     */
    public function parts()
    {
        return $this->parts_reserved;
    }

}
