<?php

use Toiee\haik\Form\Parts\Radio;

class RadioTest extends TestCase {

    /**
     * @dataProvider partProvider
     */
    public function testRender($type, $parts, $assert)
    {
        $form = new Radio($type, $parts);

        $viewdata = $form->render();
        $viewdata = preg_replace('/\t|\r|\n| {2,}/', '', trim($viewdata));
        $this->assertEquals($assert, $viewdata);
    }
    
    /**
     * @dataProvider partProvider
     */
    public function partProvider()
    {
        $param = array(
            'id' => 1,
            'type'     => 'radio',
            'name'     => 'vegitable',
            'label'    => 'organic',
            'class'    => '',
            'options'  => array('carrot', 'potato', 'onion'),
            'value'    => 'onion',
            'required' => 1,
            'valign'   => 'vertical',
            'help'     => 'おいしいジュースです',
        );

        $test = array(
            'none' => array(
                'type'   => '',
                'parts'  => array(),
                'assert' => ''
                    .'<div class="form-group">'
                    .  '<label for="haik_form__radio" class="control-label">'
                    .    ''
                    .  '</label>'
                    .  '<div>'
                    .  '</div>'
                    .'</div>',
            ),
            'vertical'  => array(
                'type'   => 'vertical',
                'parts'  => $param,
                'assert' => ''
                    .'<div class="form-group">'
                    .  '<label for="haik_form_' . $param['id'] .'_' . $param['name'] . '" class="control-label">'
                    .    $param['label'] . '<span class="haik-form-required">*</span>'
                    .  '</label>'
                    .  '<div>'
                    .    '<label class="radio-inline">'
                    .      '<input type="radio" name="data[' . $param['name'] . '][]" value="' . e($param['options'][0]) . '" id="haik_form_' . $param['id'] . '_' . $param['name'] . '">' . e($param['options'][0])
                    .    '</label>'
                    .    '<label class="radio-inline">'
                    .      '<input type="radio" name="data[' . $param['name'] . '][]" value="' . e($param['options'][1]) . '" id="haik_form_' . $param['id'] . '_' . $param['name'] . '">' . e($param['options'][1])
                    .    '</label>'
                    .    '<label class="radio-inline">'
                    .      '<input type="radio" name="data[' . $param['name'] . '][]" value="' . e($param['options'][2]) . '" id="haik_form_' . $param['id'] . '_' . $param['name'] . '" checked>' . e($param['options'][2])
                    .    '</label>'
                    .  '</div>'
                    .  '<span class="help-block">'
                    .    $param['help']
                    .  '</span>'
                    .'</div>',
            ),
            'horizontal'  => array(
                'type'   => 'horizontal',
                'parts'  => $param,
                'assert' => ''
                    .'<div class="form-group">'
                    .  '<label for="haik_form_' . $param['id'] .'_' . $param['name'] . '" class="control-label col-sm-3">'
                    .    $param['label'] . '<span class="haik-form-required">*</span>'
                    .  '</label>'
                    .  '<div class="col-sm-9">'
                    .      '<label class="radio-inline">'
                    .        '<input type="radio" name="data[' . $param['name'] . '][]" value="' . e($param['options'][0]) . '" id="haik_form_' . $param['id'] . '_' . $param['name'] . '">' . e($param['options'][0])
                    .      '</label>'
                    .      '<label class="radio-inline">'
                    .        '<input type="radio" name="data[' . $param['name'] . '][]" value="' . e($param['options'][1]) . '" id="haik_form_' . $param['id'] . '_' . $param['name'] . '">' . e($param['options'][1])
                    .      '</label>'
                    .      '<label class="radio-inline">'
                    .        '<input type="radio" name="data[' . $param['name'] . '][]" value="' . e($param['options'][2]) . '" id="haik_form_' . $param['id'] . '_' . $param['name'] . '" checked>' . e($param['options'][2])
                    .      '</label>'
                    .    '<span class="help-block">'
                    .      $param['help']
                    .    '</span>'
                    .  '</div>'
                    .'</div>',
            ),
            'linear'  => array(
                'type'   => 'linear',
                'parts'  => $param,
                'assert' => ''
                    .'<div class="form-group">'
                    .  '<label for="haik_form_' . $param['id'] .'_' . $param['name'] . '" class="sr-only">'
                    .    $param['label'] . '<span class="haik-form-required">*</span>'
                    .  '</label>'
                    .  '<div class="radio">'
                    .    '<label>'
                    .        '<input type="radio" name="data[' . $param['name'] . '][]" value="' . e($param['options'][0]) . '" id="haik_form_' . $param['id'] . '_' . $param['name'] . '">' . e($param['options'][0])
                    .    '</label>'
                    .  '</div>'
                    .  '<div class="radio">'
                    .    '<label>'
                    .      '<input type="radio" name="data[' . $param['name'] . '][]" value="' . e($param['options'][1]) . '" id="haik_form_' . $param['id'] . '_' . $param['name'] . '">' . e($param['options'][1])
                    .    '</label>'
                    .  '</div>'
                    .  '<div class="radio">'
                    .    '<label>'
                    .      '<input type="radio" name="data[' . $param['name'] . '][]" value="' . e($param['options'][2]) . '" id="haik_form_' . $param['id'] . '_' . $param['name'] . '" checked>' . e($param['options'][2])
                    .    '</label>'
                    .  '</div>'
                    .'</div>',
            ),
        );
        
        return $test;
    }
    
}
