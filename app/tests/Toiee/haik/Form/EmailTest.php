<?php

use Toiee\haik\Form\Parts\Email;

class EmailTest extends TestCase {

    /**
     * @dataProvider partProvider
     */
    public function testRender($type, $parts, $assert)
    {
        $form = new Email($type, $parts);

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
            'type' => 'text',
            'name' => 'email',
            'label' => 'organic',
            'class' => '',
            'size'  => 'col-sm-8',
            'before' => '¥',
            'after' => '円',
            'icon'  => 'search',
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
                    .  '<label for="haik_form__email" class="control-label">'
                    .    ''
                    .  '</label>'
                    .  '<div class="row">'
                    .    '<div class="col-sm-6">'
                    .      '<input type="text" name="data[email]" value="" id="haik_form__email" class="form-control" placeholder="">'
                    .    '</div>'
                    .  '</div>'
                    .'</div>',
            ),
            'vertical'  => array(
                'type'   => 'vertical',
                'parts'  => $param,
                'assert' => ''
                    .'<div class="form-group has-feedback">'
                    .  '<label for="haik_form_' . $param['id'] .'_' . $param['name'] . '" class="control-label">'
                    .    $param['label'] . '<span class="haik-form-required">*</span>'
                    .  '</label>'
                    .  '<div class="row">'
                    .    '<div class="' . $param['size'] . '">'
                    .      '<span class="glyphicon glyphicon-'.$param['icon']. ' form-control-feedback"></span>'
                    .      '<input type="text" name="data[' . $param['name'] . ']" value="' . e($param['value']) . '" id="haik_form_' . $param['id'] . '_' . $param['name'] . '" class="form-control" placeholder="' . e($param['placeholder']) . '" required>'
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
                    .'<div class="form-group has-feedback">'
                    .  '<label for="haik_form_' . $param['id'] .'_' . $param['name'] . '" class="control-label col-sm-3">'
                    .    $param['label'] . '<span class="haik-form-required">*</span>'
                    .  '</label>'
                    .  '<div class="col-sm-9">'
                    .    '<div class="row">'
                    .      '<div class="' . $param['size'] . '">'
                    .        '<span class="glyphicon glyphicon-'.$param['icon']. ' form-control-feedback"></span>'
                    .        '<input type="text" name="data[' . $param['name'] . ']" value="' . e($param['value']) . '" id="haik_form_' . $param['id'] . '_' . $param['name'] . '" class="form-control" placeholder="' . e($param['placeholder']) . '" required>'
                    .      '</div>'
                    .      '<span class="help-block">'
                    .        $param['help']
                    .      '</span>'
                    .    '</div>'
                    .  '</div>'
                    .'</div>',
            ),
            'linear'  => array(
                'type'   => 'linear',
                'parts'  => $param,
                'assert' => ''
                    .'<div class="form-group has-feedback">'
                    .  '<label for="haik_form_' . $param['id'] .'_' . $param['name'] . '" class="sr-only">'
                    .    $param['label']
                    .  '</label>'
                    .  '<div class="'.$param['size'].'">'
                    .    '<span class="glyphicon glyphicon-'.$param['icon']. ' form-control-feedback"></span>'
                    .    '<input type="text" name="data[' . $param['name'] . ']" value="' . e($param['value']) . '" id="haik_form_' . $param['id'] . '_' . $param['name'] . '" class="form-control" placeholder="' . e($param['placeholder']) . '" required>'
                    .  '</div>'
                    .'</div>',
            ),
        );
        
        return $test;
    }
    
}
