<?php
namespace Toiee\haik\Form;

class VerticalFormFactory extends FormFactory {

    protected $parts_reserved = array('text', 'email', 'textarea', 'checkbox', 'radio', 'select', 'hidden', 'file', 'agree');

}
