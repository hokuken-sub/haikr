<?php
namespace Toiee\haik\Form\Parts;

use Toiee\haik\Form\FormPartInterface;

class Text implements FormPartInterface {

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
	 * The reserved form attributes.
	 *
	 * @var array
	 */
    protected $reserved = array('id', 'name', 'label', 'value', 'size', 'required', 'placeholder', 'help', 'icon', 'before', 'after', 'error');


	/**
	 * Create a new form instance.
	 *
	 * @param  string  $form_type
	 * @param  array  $options form attributes
	 * @return void
	 */
    public function __construct($form_type = 'vertical', $options = array())
    {
        $this->form_type = ($form_type === '' ? 'vertical' : $form_type);

        $this->attributes = array(
            'id'      => '',
            'name'    => 'text',
            'label'   => '',
            'value'   => '',
            'size'    => '',
            'required' => 0,
        );

        if (count($options) > 0)
        {
            $this->attributes = array_merge($this->attributes, array_intersect_key($options, array_flip($this->reserved)));
        }
    }

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
        $namespace = class_basename(get_called_class());
        $viewfile = $namespace . '::' . 'text';

        if ( ! \View::exists($viewfile))
        {
            $dirname = dirname(__DIR__) . '/views/' . $this->form_type . '/parts';
            \View::addLocation($dirname);
            \View::addNamespace($namespace, $dirname);
        }

        return \View::make($viewfile, $this->attributes)->render();
    }

}
