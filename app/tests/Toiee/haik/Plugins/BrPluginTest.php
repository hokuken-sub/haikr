<?php
use Toiee\haik\Plugins\Br\BrPlugin;

class BrPluginTest extends TestCase {

    public function testInlineMethodExists()
    {
        $this->assertInternalType('string', with(new BrPlugin)->inline());
    }
    
    public function testConvertMethodExists()
    {
        $this->assertInternalType('string', with(new BrPlugin)->convert());
    }
    
    public function testIsInlineMethodReturnRight()
    {
        $normal = array('br' => array(), 'assert' => '<br>\n');
        $this->assertEquals($normal['assert'], with(new BrPlugin)->inline());
    }

    public function testIsConvertMethodReturnRight()
    {
        $normal = array('br' => array(), 'assert' => '<br>');
        $this->assertEquals($normal['assert'], with(new BrPlugin)->convert());
    }

}