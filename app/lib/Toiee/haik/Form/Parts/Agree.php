<?php
namespace Toiee\haik\Form\Parts;

class Agree extends Base {

	/**
	 * The reserved form attributes.
	 *
	 * @var array
	 */
    protected $reserved = array('id', 'name', 'label', 'value', 'terms_text', 'required', 'help', 'error');


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
            'name'    => 'agree',
            'label'   => '',
            'terms_text' => '',
            'value'   => '',
            'required' => 0,
        );

        if (count($options) > 0)
        {
            $this->attributes = array_merge($this->attributes, array_intersect_key($options, array_flip($this->reserved)));
        }
    }

}
