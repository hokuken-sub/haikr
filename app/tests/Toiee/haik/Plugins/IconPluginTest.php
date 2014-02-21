<?php
use Toiee\haik\Plugins\Icon\IconPlugin;

class IconPluginTest extends TestCase {

    public function testInlineMethodExists()
    {
        $this->assertInternalType('string', with(new IconPlugin)->inline());
    }
    
    public function testParameter()
    {
        $tests = array(
            // !TODO: paramsが無いとき、エラー処理
            'no_params' => array(
                'icon' => array(),
                'assert' => 'error',
            ),
            'default' => array(
                'icon' => array('search'),
                'assert' => '<i class="haik-plugin-icon glyphicon glyphicon-search"></i>',
            ),
            'search' => array(
                'icon' => array('glyphicon', 'search'),
                'assert' => '<i class="haik-plugin-icon glyphicon glyphicon-search"></i>',
            ),
            'search_reverse' => array(
                'icon' => array('search', 'glyphicon'),
                'assert' => '<i class="haik-plugin-icon glyphicon glyphicon-search"></i>',
            ),
            'escape_html_char' => array(
                'icon' => array('<h1>'),
                'assert' => '<i class="haik-plugin-icon glyphicon glyphicon-&lt;h1&gt;"></i>',
            ),

        );
        
        foreach ($tests as $key => $data)
        {
            $this->assertEquals($data['assert'], with(new IconPlugin)->inline($data['icon']));
        }

        $this->markTestIncomplete(
            'This test is Incomplete.'
        );

    }
}