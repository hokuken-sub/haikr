<?php

use Toiee\haik\Form\Parts\Textarea;

class TextareaTest extends TestCase {

    /**
     * @dataProvider partProvider
     */
    public function testRender($type, $parts, $assert)
    {
        $form = new Textarea($type, $parts);

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
            'type' => 'textarea',
            'name' => 'note',
            'label' => 'organic',
            'class' => '',
            'rows' => 5,
            'size'  => 'col-sm-8',
            'value' => 1000,
            'placeholder' => '果汁',
            'required' => 1,
            'help' => 'おいしいジュースです',
        );

        $test = array(
            'none' => array(
                'type'   => '',
                'parts'  => array(),
                'assert' => ''
                    .'<div class="form-group">'
                    .  '<label for="haik_form__textarea" class="control-label">'
                    .    ''
                    .  '</label>'
                    .  '<div class="row">'
                    .    '<div class="col-sm-6">'
                    .      '<textarea name="data[textarea]" id="haik_form__textarea" class="form-control" rows="3" placeholder=""></textarea>'
                    .    '</div>'
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
                    .  '<div class="row">'
                    .    '<div class="' . $param['size'] . '">'
                    .      '<textarea name="data[' . $param['name'] . ']" id="haik_form_' . $param['id'] . '_' . $param['name'] . '" class="form-control" rows="' . $param['rows'] . '" placeholder="' . e($param['placeholder']) . '" required>' . e($param['value']) . '</textarea>'
                    .    '</div>'
                    .    '<span class="help-block">'
                    .      $param['help']
                    .    '</span>'
                    .  '</div>'
                    .'</div>',
            ),            'horizontal'  => array(
                'type'   => 'horizontal',
                'parts'  => $param,
                'assert' => ''
                    .'<div class="form-group">'
                    .  '<label for="haik_form_' . $param['id'] .'_' . $param['name'] . '" class="control-label col-sm-3">'
                    .    $param['label'] . '<span class="haik-form-required">*</span>'
                    .  '</label>'
                    .  '<div class="col-sm-9">'
                    .    '<div class="row">'
                    .      '<div class="' . $param['size'] . '">'
                    .        '<textarea name="data[' . $param['name'] . ']" id="haik_form_' . $param['id'] . '_' . $param['name'] . '" class="form-control" rows="' . $param['rows'] . '" placeholder="' . e($param['placeholder']) . '" required>' . e($param['value']) . '</textarea>'
                    .      '</div>'
                    .      '<span class="help-block">'
                    .        $param['help']
                    .      '</span>'
                    .    '</div>'
                    .  '</div>'
                    .'</div>',
            ),
        );
        
        return $test;
    }
    
}
