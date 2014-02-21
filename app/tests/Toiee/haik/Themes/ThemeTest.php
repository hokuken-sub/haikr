<?php
use Toiee\haik\Themes\Theme;

class ThemeTest extends TestCase {
    
    public function setUp()
    {
        \App::bind('ThemeConfigLoaderInterface', function()
        {
            $dummyOptions = array(
                'name' => 'kawaz',
                'layouts' => array(
                    'content', 'top'
                ),
                'default_layout' => 'top',
                'colors' => array('blue', 'green', 'red'),
                'textures' => array('dot', 'hemp'),
            );
            $mock = Mockery::mock('Toiee\haik\Themes\ThemeConfigLoaderInterface');
            $mock->shouldReceive('load')->andReturn($dummyOptions);
            return $mock;
        });
        
        App::bind('HaikTheme', function()
        {
            return new Theme(
                App::make('ThemeManager'),
                App::make('ThemeConfigLoaderInterface')
            );
        });
    }
    
    public function testHasConfig()
    {
        $theme = App::make('HaikTheme');
        $this->assertTrue($theme->has('name'));
    }
    
    public function testGetConfig()
    {
        $theme = App::make('HaikTheme');
        $this->assertEquals('kawaz', $theme->get('name'));
    }
    
    public function testDefaultLayoutGet()
    {
        $theme = App::make('HaikTheme');
        $this->assertEquals('top', $theme->layoutGet());
    }
    
    public function testLayoutSetAndGet()
    {
        $theme = App::make('HaikTheme');
        $theme->layoutSet('content');
        $this->assertEquals('content', $theme->layoutGet());
    }
    
    public function testDefaultColorGet()
    {
        $theme = App::make('HaikTheme');
        $this->assertFalse($theme->colorGet());
    }
    
    public function testColorSetAndGet()
    {
        $theme = App::make('HaikTheme');
        $theme->colorSet('blue');
        $this->assertEquals('blue', $theme->colorGet());
    }
    
    public function testInvalidColorSetAndIgnore()
    {
        $theme = App::make('HaikTheme');
        $theme->colorSet('invalid_color');
        $this->assertFalse($theme->colorGet());
    }
    
    public function testDefaultTextureGet()
    {
        $theme = App::make('HaikTheme');
        $this->assertFalse($theme->textureGet());
    }

    public function testTextureSetAndGet()
    {
        $theme = App::make('HaikTheme');
        $theme->textureSet('hemp');
        $this->assertEquals('hemp', $theme->textureGet());
    }
    
    public function testInvalidTexureSetAndIgnore()
    {
        $theme = App::make('HaikTheme');
        $theme->textureSet('invalid_texture');
        $this->assertFalse($theme->textureGet());
    }
    
    public function testMake()
    {
        $theme = App::make('HaikTheme');
        $this->assertInstanceOf('View', $theme->make());
    }
    
    public function testTakeOverTheme()
    {
        $theme = App::make('HaikTheme');
        $theme->colorSet('blue');
        $theme->textureSet('hemp');

        App::bind('ThemeConfigLoaderInterface', function()
        {
            $dummyOptions = array(
                'name' => 'semi',
                'layouts' => array(
                    'content',
                ),
                'default_layout' => 'content',
                'colors' => array('blue'),
                'textures' => array(),
            );
            $mock = Mockery::mock('Toiee\haik\Themes\ThemeConfigLoaderInterface');
            $mock->shouldReceive('load')->andReturn($dummyOptions);
            return $mock;
        });
        
        // take over below status
        // layout: content
        // color: blue
        // texture: false
        
        $new_theme = new Theme(
            App::make('ThemeManager'),
            App::make('ThemeConfigLoaderInterface'),
            $theme
        );

        $this->assertEquals('content', $new_theme->layoutGet());
        $this->assertEquals('blue', $new_theme->colorGet());
        $this->assertFalse($new_theme->textureGet());
        
    }
    
    /**
     * @expectedException Toiee\haik\Themes\ThemeNotHasLayoutsException
     */
    public function testSetNoLayoutsConfigThrowsException()
    {
        App::bind('ThemeConfigLoaderInterface', function()
        {
            $dummyOptions = array(
                'name' => 'semi',
                'layouts' => array(),
                'default_layout' => 'content',
                'colors' => array('blue'),
                'textures' => array(),
            );
            $mock = Mockery::mock('Toiee\haik\Themes\ThemeConfigLoaderInterface');
            $mock->shouldReceive('load')->andReturn($dummyOptions);
            return $mock;
        });

        $theme = App::make('HaikTheme');
    }
    
}