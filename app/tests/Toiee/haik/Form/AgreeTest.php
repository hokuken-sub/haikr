<?php

use Toiee\haik\Form\Parts\Agree;

class AgreeTest extends TestCase {

    /**
     * @dataProvider partProvider
     */
    public function testRender($type, $parts, $assert)
    {
        $form = new Agree($type, $parts);

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
            'type'     => 'agree',
            'name'     => 'agreeee',
            'label'    => 'agreement',
            'terms_text' => 'Are you sure?',
            'class'    => '',
            'value'    => '',
            'required' => 1,
            'help'     => 'おいしいジュースです',
        );

        $test = array(
            'none' => array(
                'type'   => '',
                'parts'  => array(),
                'assert' => ''
                    .'<div class="form-group">'
                    .  '<input type="hidden" name="data[agree]" value="0">'
                    .  '<label for="haik_form__agree" class="control-label">'
                    .  ''
                    .  '</label>'
                    .  '<div class="checkbox">'
                    .    '<label>'
                    .      '<input type="checkbox" name="data[agree]" value="1" id="haik_form__agree">'
                    .    '</label>'
                    .  '</div>'
                    .'</div>',
            ),
            'vertical'  => array(
                'type'   => 'vertical',
                'parts'  => $param,
                'assert' => ''
                    .'<div class="form-group">'
                    .  '<input type="hidden" name="data[' . $param['name'] . ']" value="0">'
                    .  '<label for="haik_form_' . $param['id'] . '_' . $param['name'] . '" class="control-label">'
                    .    $param['label'] . '<span class="haik-form-required">*</span>'
                    .  '</label>'
                    .  '<div class="checkbox">'
                    .    '<label>'
                    .      '<input type="checkbox" name="data[' . $param['name'] . ']" value="1" id="haik_form_' . $param['id'] . '_' . $param['name'] . '">' . e($param['terms_text'])
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
                    .  '<input type="hidden" name="data[' . $param['name'] . ']" value="0">'
                    .  '<label for="haik_form_' . $param['id'] . '_' . $param['name'] . '" class="control-label col-sm-3">'
                    .    $param['label'] . '<span class="haik-form-required">*</span>'
                    .  '</label>'
                    .  '<div class="col-sm-9">'
                    .    '<div class="checkbox">'
                    .      '<label>'
                    .        '<input type="checkbox" name="data[' . $param['name'] . ']" value="1" id="haik_form_' . $param['id'] . '_' . $param['name'] . '">' . e($param['terms_text'])
                    .      '</label>'
                    .    '</div>'
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
                    .  '<input type="hidden" name="data[' . $param['name'] . ']" value="0">'
                    .  '<label for="haik_form_' . $param['id'] . '_' . $param['name'] . '" class="sr-only">'
                    .    e($param['label'])
                    .  '</label>'
                    .  '<div class="checkbox">'
                    .    '<label>'
                    .        '<input type="checkbox" name="data[' . $param['name'] . ']" value="1" id="haik_form_' . $param['id'] . '_' . $param['name'] . '">' . e($param['terms_text'])
                    .    '</label>'
                    .  '</div>'
                    .'</div>',
            ),
        );
        
        return $test;
    }
    
}
