<?php
use Toiee\haik\Plugins\Label\LabelPlugin;

class LabelPluginTest extends TestCase {

    public function testInlineMethodExists()
    {
        $this->assertInternalType('string', with(new LabelPlugin)->inline());
    }
    
    public function testParameter()
    {
        $tests = array(
            'default' => array(
                'label' => array(''),
                'assert' => '<span class="haik-plugin-label label label-default">test</span>',
            ),
            'info' => array(
                'label' => array('info'),
                'assert' => '<span class="haik-plugin-label label label-info">test</span>',
            ),
            'custom_class' => array(
                'label' => array('hoge'),
                'assert' => '<span class="haik-plugin-label label label-default hoge">test</span>',
            ),
            'custom_class_escape' => array(
                'label' => array('<h1>'),
                'assert' => '<span class="haik-plugin-label label label-default &lt;h1&gt;">test</span>',
            ),

        );
        
        foreach ($tests as $key => $data)
        {
            $this->assertEquals($data['assert'], with(new LabelPlugin)->inline($data['icon']));
        }

    }
}