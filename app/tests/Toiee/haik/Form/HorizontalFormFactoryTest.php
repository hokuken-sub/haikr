<?php

use Toiee\haik\Form\HorizontalFormFactory;

class HorizontalFormFactoryTest extends TestCase {
    
    public function testFactory()
    {
        $form_type = 'horizontal';
        $part_type = 'text';

        $form = new HorizontalFormFactory($form_type);
        $part = $form->partsFactory($part_type);

        $this->assertInstanceOf('\Toiee\haik\Form\Parts\Text', $part);
    }

}
