<?php
namespace Toiee\haik\Form;

interface FormFactoryInterface {

    /**
     * Return form parts 
     *
     * @param  string $type form parts type
     * @param  array  $options form data
     * @return FormPart form parts
     */
    public function factory($type, $options = array());

    /**
     * Return parts array
     *
     * @return array parts able to use form
     */
    public function parts();

}
