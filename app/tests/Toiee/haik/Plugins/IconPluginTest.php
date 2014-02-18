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
                'assert' => '<i class="glyphicon glyphicon-search">',
            ),
        );
        
        foreach ($tests as $key => $data)
        {
            $this->assertEquals($data['assert'], with(new IconPlugin)->inline($data['icon']));
        }
    }
}