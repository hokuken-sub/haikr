<?php
namespace Toiee\haik\Form\Parts;

class Textarea extends Base {

	/**
	 * The reserved form attributes.
	 *
	 * @var array
	 */
    protected $reserved = array('id', 'name', 'label', 'value', 'size', 'required', 'rows', 'placeholder', 'help', 'error');


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
            'id'       => '',
            'name'     => 'textarea',
            'label'    => '',
            'value'    => '',
            'size'     => 'col-sm-6',
            'rows'     => 3,
            'required' => 0,
        );

        if (count($options) > 0)
        {
            $this->attributes = array_merge($this->attributes, array_intersect_key($options, array_flip($this->reserved)));
        }
    }

}
