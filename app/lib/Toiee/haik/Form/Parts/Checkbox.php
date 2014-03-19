<?php
namespace Toiee\haik\Form\Parts;

class Checkbox extends Base {

	/**
	 * The reserved form attributes.
	 *
	 * @var array
	 */
    protected $reserved = array('id', 'name', 'label', 'value', 'valign' , 'options', 'required', 'help', 'error');


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
            'name'    => 'checkbox',
            'label'   => '',
            'value'   => array(),
            'options' => array(),
            'valign'   => 'vertical',
            'required' => 0,
        );
        
        if (isset($options['value']) && ! is_array($options['value']))
        {
            $options['value'] = array($options['value']);
        }

        if (count($options) > 0)
        {
            $this->attributes = array_merge($this->attributes, array_intersect_key($options, array_flip($this->reserved)));
        }
    }

}