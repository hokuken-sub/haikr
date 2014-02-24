<?php
use Toiee\haik\Themes\ThemeConfigParser;

class ThemeConfigParserTest extends TestCase {

    public function testParseFullStackOptions()
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
        
        $parser = App::make('ThemeConfigParserInterface');
        $result = $parser->parse($full_stack_options);
        
        $this->assertEquals($full_stack_options, $result);
    }
}