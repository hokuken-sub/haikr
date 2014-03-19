<?php
namespace Toiee\haik\Form;

class Button implements ButtonInterface {

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
    protected $reserved = array('color', 'value', 'confirm', 'send');

	/**
	 * Create a new form instance.
	 *
	 * @param  string  $form_type
	 * @param  array  $options form attributes
	 * @return void
	 */
    public function __construct($form_type = 'vertical', $options = array(), $status = 'confirm')
    {
        $this->form_type = ($form_type === '' ? 'vertical' : $form_type);

        $this->attributes = array(
            'id'      => '',
            'color'   => 'default',
            'value'   => 'Confirm',
            'confirm' => 'Confirm',
            'send'    => 'Send',
        );
        
        if (count($options) > 0)
        {
            $options['value'] = ($status === 'confirm') ? $options['confirm'] : $options['send'];
            $this->attributes = array_merge($this->attributes, array_intersect_key($options, array_flip($this->reserved)));
        }
    }

    /**
     * Make part html 
     *
     * return string part html
     */
    public function render()
    {
        $classname = class_basename(get_called_class());
        $namespace = 'Form';
        $viewfile = $namespace . '::' . $this->form_type . '.'. strtolower($classname);

        if ( ! \View::exists($viewfile))
        {
            $dirname = __DIR__ . '/views';
            \View::addLocation($dirname);
            \View::addNamespace($namespace, $dirname);
        }

        return \View::make($viewfile, $this->attributes)->render();
    }

}
