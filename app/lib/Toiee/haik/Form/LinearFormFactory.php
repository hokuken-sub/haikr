<?php
namespace Toiee\haik\Form;

class LinearFormFactory extends FormFactory {

    protected $parts_reserved = array('text', 'email', 'checkbox', 'radio', 'select', 'hidden', 'file', 'agree');

}
