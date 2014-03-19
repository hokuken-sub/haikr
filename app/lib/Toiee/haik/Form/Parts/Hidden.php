<?php
namespace Toiee\haik\Form\Parts;

class Hidden extends Base {

	/**
	 * The reserved form attributes.
	 *
	 * multiple option cannot use liner
	 *
	 * @var array
	 */
    protected $reserved = array('id', 'name', 'value');

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
            'name'     => 'hidden',
            'value'    => '',
        );
        
        if (count($options) > 0)
        {
            $this->attributes = array_merge($this->attributes, array_intersect_key($options, array_flip($this->reserved)));
        }
    }

}
