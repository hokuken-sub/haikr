<?php

use Toiee\haik\Form\Parts\Hidden;

class HiddenTest extends TestCase {

    /**
     * @dataProvider partProvider
     */
    public function testRender($type, $parts, $assert)
    {
        $form = new Hidden($type, $parts);

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
            'type'     => 'hidden',
            'name'     => 'wasabi',
            'value'    => 'japanese wasabi',
        );

        $test = array(
            'none' => array(
                'type'   => '',
                'parts'  => array(),
                'assert' => ''
                    .'<input type="hidden" name="data[hidden]" id="haik_form__hidden" value="">',
            ),
            'vertical'  => array(
                'type'   => 'vertical',
                'parts'  => $param,
                'assert' => ''
                    .'<input type="hidden" name="data[' . $param['name'] . ']" id="haik_form_' . $param['id'] .'_' . $param['name'] . '" value="'. e($param['value']) .'">',
            ),
            'horizontal'  => array(
                'type'   => 'horizontal',
                'parts'  => $param,
                'assert' => ''
                    .'<input type="hidden" name="data[' . $param['name'] . ']" id="haik_form_' . $param['id'] .'_' . $param['name'] . '" value="'. e($param['value']) .'">',

            ),
            'linear'  => array(
                'type'   => 'linear',
                'parts'  => $param,
                'assert' => ''
                    .'<input type="hidden" name="data[' . $param['name'] . ']" id="haik_form_' . $param['id'] .'_' . $param['name'] . '" value="'. e($param['value']) .'">',
            ),
        );
        
        return $test;
    }
    
}
