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
            'none' => array(
                'icon' => array(),
                'assert' => 'error',
            ),
            'search' => array(
                'icon' => array('glyphicon', 'search'),
                'assert' => '<i class="glyphicon glyphicon-search"></i>',
            ),
            'search_reverse' => array(
                'icon' => array('search', 'glyphicon'),
                'assert' => '<i class="glyphicon glyphicon-search"></i>',
            ),
            'no_icon_type' => array(
                'icon' => array('search'),
                'assert' => '<i class="search"></i>',
            ),
        );
        
        foreach ($tests as $key => $data)
        {
            $this->assertEquals($data['assert'], with(new IconPlugin)->inline($data['icon']));
        }
        $this->markTestIncomplete();
    }
}