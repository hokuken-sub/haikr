<?php
use Toiee\haik\Themes\ThemeConfigParser;
use Config;

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
        	'layouts' => array(
        		'top' => array(
        			'filename' => 'top.skin.php',
        			'partials' => array('SiteNavigator', 'SiteFooter'),
        			'thumbnail' => 'img/thumbnail.top.png',
        		),
        		'content' => array(
        			'filename' => 'content.skin.php',
        			'partials' => array('SiteNavigator', 'SiteFooter', 'MenuBar'),
        			'thumbnail' => 'img/thumbnail.content.png',
        		),
        	),
        	'default_layout' => 'top',
        	'colors' => array(
        		'black'          => 'css/color.black.css',
        		'brown'          => 'css/color.brown.css',
        	),
        	'textures' => array(
        		'hemp'        => 'css/texture.hemp.css',
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
            'layouts' => array("top", "content"),
            'default_layout' => 'top',
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
            'layouts' => array("top", "content"),
            'default_layout' => 'top',
            'colors' => array('black', 'white', 'raspberry'),
        );
        $expected_colors = array(
            'black' => array(
                'className' => 'haik-theme-kawaz-color-black',
            ),
            'white' => array(
                'className' => 'haik-theme-kawaz-color-white',
            ),
            'raspberry' => array(
                'className' => 'haik-theme-kawaz-color-raspberry',
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
            'layouts' => array("top", "content"),
            'default_layout' => 'top',
            'textures' => array('hemp', 'tile', 'stripe'),
        );
        $expected_textures = array(
            'hemp' => array(
                'className' => 'haik-theme-kawaz-texture-hemp',
            ),
            'tile' => array(
                'className' => 'haik-theme-kawaz-texture-tile',
            ),
            'stripe' => array(
                'className' => 'haik-theme-kawaz-texture-stripe',
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
            'layouts' => array('top', 'content'),
        );
        $expected = 'top';
        
        $result = $this->parser->parse($shorthand_options);
        $this->assertEquals($expected, $result['default_layout']);
    }
}