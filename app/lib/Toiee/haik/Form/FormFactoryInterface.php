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
    public function partsFactory($type, $options = array());

    /**
     * Return form button 
     *
     * @param  string $type form parts type
     * @param  array  $options button data
     * @return Button
     */
    public function buttonFactory($options = array(), $action = 'confirm');

    /**
     * Return parts array
     *
     * @return array parts data for use form
     */
    public function parts();

}
