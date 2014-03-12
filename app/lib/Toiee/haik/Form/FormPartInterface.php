<?php
namespace Toiee\haik\Form;

interface FormPartInterface {

    /**
     * Return parts array
     *
     * return array parts detail
     */
    public function toArray();

    /**
     * Make part html 
     *
     * return string part html
     */
    public function render();

}
