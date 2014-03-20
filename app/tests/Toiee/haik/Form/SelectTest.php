<?php

use Toiee\haik\Form\Parts\Select;

class SelectTest extends TestCase {

    /**
     * @dataProvider partProvider
     */
    public function testRender($type, $parts, $assert)
    {
        $form = new Select($type, $parts);

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
            'type'     => 'select',
            'name'     => 'tea',
            'label'    => 'organic',
            'class'    => '',
            'options'  => array('woolong', 'earl gray', 'dargiling', 'green tea'),
            'empty'    => 'choose!',
            'required' => 1,
            'help'     => 'おいしいお茶です',
        );

        $test = array(
            'none' => array(
                'type'   => '',
                'parts'  => array(),
                'assert' => ''
                    .'<div class="form-group">'
                    .  '<label for="haik_form__select" class="control-label">'
                    .    ''
                    .  '</label>'
                    .  '<select class="form-control" name="data[select]" id="haik_form__select">'
                    .  '</select>'
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
                    .  '<select class="form-control" name="data[' . $param['name'] . ']" id="haik_form_' . $param['id'] . '_' . $param['name'] . '">'
                    .    '<option value="">' . e($param['empty']) . '</option>'
                    .    '<option value="' . e($param['options'][0]) . '">' . e($param['options'][0]) . '</option>'
                    .    '<option value="' . e($param['options'][1]) . '">' . e($param['options'][1]) . '</option>'
                    .    '<option value="' . e($param['options'][2]) . '">' . e($param['options'][2]) . '</option>'
                    .    '<option value="' . e($param['options'][3]) . '">' . e($param['options'][3]) . '</option>'
                    .  '</select>'
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
                    .    '<select class="form-control" name="data[' . $param['name'] . ']" id="haik_form_' . $param['id'] . '_' . $param['name'] . '">'
                    .      '<option value="">' . e($param['empty']) . '</option>'
                    .      '<option value="' . e($param['options'][0]) . '">' . e($param['options'][0]) . '</option>'
                    .      '<option value="' . e($param['options'][1]) . '">' . e($param['options'][1]) . '</option>'
                    .      '<option value="' . e($param['options'][2]) . '">' . e($param['options'][2]) . '</option>'
                    .      '<option value="' . e($param['options'][3]) . '">' . e($param['options'][3]) . '</option>'
                    .    '</select>'
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
                    .  '<select class="form-control" name="data[' . $param['name'] . ']" id="haik_form_' . $param['id'] . '_' . $param['name'] . '">'
                    .    '<option value="">' . e($param['empty']) . '</option>'
                    .    '<option value="' . e($param['options'][0]) . '">' . e($param['options'][0]) . '</option>'
                    .    '<option value="' . e($param['options'][1]) . '">' . e($param['options'][1]) . '</option>'
                    .    '<option value="' . e($param['options'][2]) . '">' . e($param['options'][2]) . '</option>'
                    .    '<option value="' . e($param['options'][3]) . '">' . e($param['options'][3]) . '</option>'
                    .    '</select>'
                    .'</div>',
            ),
        );
        
        return $test;
    }
    
}
