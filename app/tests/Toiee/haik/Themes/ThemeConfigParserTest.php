<?php
use Toiee\haik\Themes\ThemeConfigParser;

class ThemeConfigParserTest extends TestCase {

    public function setUp()
    {
        $this->parser = new ThemeConfigParser;
    }

    public function testFullStackOptions()
    {
        $full_stack_options = array(
            'name' => 'kawaz',
            'version' => '1.0.0',
            'author' => 'toiee',
        	'layouts' => array(
        		'top' => array(
        			'filename' => 'top.theme.blade.php',
        			'partials' => array('SiteNavigator', 'SiteFooter'),
        			'thumbnail' => 'assets/images/thumbnail.top.png',
        		),
        		'content' => array(
        			'filename' => 'content.theme.blade.php',
        			'partials' => array('SiteNavigator', 'SiteFooter', 'MenuBar'),
        			'thumbnail' => 'assets/images/thumbnail.content.png',
        		),
        	),
        	'defaultLayout' => 'top',
        	'colors' => array(
        		'black'          => array('className' => 'haik-theme-color-black'),
        		'brown'          => array('className' => 'haik-theme-color-brown'),
        	),
        	'textures' => array(
        		'hemp'        => array('className' => 'haik-theme-texture-hemp'),
            )
        );
        
        $result = $this->parser->parse($full_stack_options);
        
        $this->assertEquals($full_stack_options, $result);
    }
    
    public function testShorthandLayoutsOptions()
    {
        $shorthand_options = array(
            'name' => 'kawaz',
            'version' => '1.0.0',
            'author' => 'toiee',
            'layouts' => array("top", "content"),
            'defaultLayout' => 'top',
        );
        $default_partials = Config::get('theme.partials.default', array());
        $expected_layouts = array(
            'top' => array(
                'filename' => 'top.layout.blade.php',
                'partials' => $default_partials,
                'thumbnail' => 'assets/images/top.thumbnail.png',
            ),
            'content' => array(
                'filename' => 'content.layout.blade.php',
                'partials' => $default_partials,
                'thumbnail' => 'assets/images/content.thumbnail.png',
            ),
        );
        
        $result = $this->parser->parse($shorthand_options);
        
        $this->assertEquals($expected_layouts, $result['layouts']);
    }
    
    public function testShorthandColorsOptions()
    {
        $shorthand_options = array(
            'name' => 'kawaz',
            'version' => '1.0.0',
            'author' => 'toiee',
            'layouts' => array("top", "content"),
            'defaultLayout' => 'top',
            'colors' => array('black', 'white', 'raspberry'),
        );
        $expected_colors = array(
            'black' => array(
                'className' => 'haik-theme-color-black',
            ),
            'white' => array(
                'className' => 'haik-theme-color-white',
            ),
            'raspberry' => array(
                'className' => 'haik-theme-color-raspberry',
            ),
        );

        $result = $this->parser->parse($shorthand_options);
        $this->assertEquals($expected_colors, $result['colors']);
    }
    
    public function testShorthandTexturesOptions()
    {
        $shorthand_options = array(
            'name' => 'kawaz',
            'version' => '1.0.0',
            'author' => 'toiee',
            'layouts' => array("top", "content"),
            'defaultLayout' => 'top',
            'textures' => array('hemp', 'tile', 'stripe'),
        );
        $expected_textures = array(
            'hemp' => array(
                'className' => 'haik-theme-texture-hemp',
            ),
            'tile' => array(
                'className' => 'haik-theme-texture-tile',
            ),
            'stripe' => array(
                'className' => 'haik-theme-texture-stripe',
            ),
        );

        $result = $this->parser->parse($shorthand_options);
        $this->assertEquals($expected_textures, $result['textures']);
    }
    
    public function testDefaultLayoutNotSet()
    {
        $shorthand_options = array(
            'name' => 'kawaz',
            'version' => '1.0.0',
            'author' => 'toiee',
            'layouts' => array('top', 'content'),
        );
        $expected = 'top';
        
        $result = $this->parser->parse($shorthand_options);
        $this->assertEquals($expected, $result['defaultLayout']);
    }
    
    /**
     * @expectedException Toiee\haik\Themes\ThemeInvalidConfigProvidedException
     */
    public function testProvideLackConfigValuesThrowsException()
    {
        $invalid_options = array(
            'layouts' => array("top"),
        );
        $this->parser->parse($invalid_options);
    }

    /**
     * @expectedException Toiee\haik\Themes\ThemeInvalidConfigProvidedException
     */
    public function testUsingInvalidClassNameThrowsException()
    {
        $invalid_options = array(
            'name' => 'kawaz',
            'version' => '1.0.0',
            'author' => 'toiee',
            'layouts' => array('top', 'content'),
            'colors' => array('日本語', '$_symbols_$', /*empty string*/''),
        );
        $this->parser->parse($invalid_options);
    }
}