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

    }
    
    public function testOutputErrorIfUserAuthenticatedWithNoParams()
    {
        $user = User::where('email', 'touch@toiee.jp')->first();
        $this->be($user);
        if (Auth::check())
        {
            $no_params = array(
                'icon' => array(),
                'assert' => '<p class="text-danger">You need to put parameter! ( Usage: &icon(search); )</p>',
            );
            
            $this->assertEquals($no_params['assert'], with(new IconPlugin)->inline($no_params['icon']));
        }
    }

    public function testOutputBlankIfUserNotAuthenticatedWithNoParams()
    {
        if ( ! Auth::check())
        {
            $no_params = array(
                'icon' => array(),
                'assert' => '',
            );

            $this->assertEquals($no_params['assert'], with(new IconPlugin)->inline($no_params['icon']));
        }
    }
}