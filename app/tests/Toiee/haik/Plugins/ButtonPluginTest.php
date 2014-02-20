<?php
use Toiee\haik\Plugins\Button\ButtonPlugin;

class ButtonPluginTest extends TestCase {

    public function testInlineMethodExists()
    {
        $this->assertInternalType('string', with(new ButtonPlugin)->inline());
    }
    
    public function testParameter()
    {
        $tests = array(
            'none' => array(
                'button' => array(),
                'assert' => '<a class="haik-plugin-button btn btn-default" href="#">test</a>',
            ),
            'url' => array(
                'button' => array('http://hokuken.com'),
                'assert' => '<a class="haik-plugin-button btn btn-default" href="http://hokuken.com">test</a>',
            ),
            'nopage' => array(
                'button' => array('Keishi'),
                'assert' => '<a class="haik-plugin-button btn btn-default" href="' . Haik::pageUrl('Keishi') . '">test</a>',
            ),
            'none' => array(
                'button' => array('FrontPage'),
                'assert' => '<a class="haik-plugin-button btn btn-default" href="' . Haik::pageUrl('FrontPage') . '">test</a>',
            ),
            'primary' => array(
                'button' => array('FrontPage', 'primary'),
                'assert' => '<a class="haik-plugin-button btn btn-primary" href="' . Haik::pageUrl('FrontPage') . '">test</a>',
            ),
            'large' => array(
                'button' => array('FrontPage', 'large'),
                'assert' => '<a class="haik-plugin-button btn btn-default btn-lg" href="' . Haik::pageUrl('FrontPage') .'">test</a>',
            ),
            'small' => array(
                'button' => array('FrontPage', 'small'),
                'assert' => '<a class="haik-plugin-button btn btn-default btn-sm" href="' . Haik::pageUrl('FrontPage') . '">test</a>',
            ),
            'mini' => array(
                'button' => array('FrontPage', 'mini'),
                'assert' => '<a class="haik-plugin-button btn btn-default btn-xs" href="' . Haik::pageUrl('FrontPage') . '">test</a>',
            ),
            'block' => array(
                'button' => array('FrontPage', 'block'),
                'assert' => '<a class="haik-plugin-button btn btn-default btn-block" href="' . Haik::pageUrl('FrontPage') . '">test</a>',
            ),
            'custom' => array(
                'button' => array('FrontPage', 'custom'),
                'assert' => '<a class="haik-plugin-button btn btn-default custom" href="' . Haik::pageUrl('FrontPage') . '">test</a>',
            ),
        );
        
        foreach ($tests as $key => $data)
        {
            $this->assertEquals($data['assert'], with(new ButtonPlugin)->inline($data['button'],'test'));
        }
    }
}