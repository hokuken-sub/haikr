<?php

use Toiee\haik\Form\Parts\File;

class FileTest extends TestCase {

    /**
     * @dataProvider partProvider
     */
    public function testRender($type, $parts, $assert)
    {
        $form = new File($type, $parts);
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
            'id'       => 1,
            'type'     => 'file',
            'name'     => 'image',
            'label'    => 'imagefile',
            'value'    => '',
            'class'    => '',
            'required' => 1,
            'help'     => 'おいしいジュースです',
        );

        $test = array(
            'none' => array(
                'type'   => '',
                'parts'  => array(),
                'assert' => ''
                    .'<div class="form-group">'
                    .  '<label for="haik_form__file" class="control-label">'
                    .    ''
                    .  '</label>'
                    .  '<input type="file" name="data[file]" id="haik_form__file" value="">'
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
                    .  '<input type="file" name="data[' . $param['name'] . ']" id="haik_form_' . $param['id'] . '_' . $param['name'] . '" value="" required>'
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
                    .    '<input type="file" name="data[' . $param['name'] . ']" id="haik_form_' . $param['id'] . '_' . $param['name'] . '" value="" required>'
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
                    .    $param['label']
                    .  '</label>'
                    .  '<input type="file" name="data[' . $param['name'] . ']" id="haik_form_' . $param['id'] . '_' . $param['name'] . '" value="" required>'
                    .'</div>',
            ),
        );
        
        return $test;
    }
    
}
