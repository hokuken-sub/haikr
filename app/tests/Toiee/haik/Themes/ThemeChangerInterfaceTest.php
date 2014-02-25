<?php
use Toiee\haik\Themes\ThemeChangerInterface;

class ThemeChangerInterfaceTest extends TestCase {

    public function testSetThemeByThemeInterface()
    {
        $mock_theme = Mockery::mock('Toiee\haik\Themes\ThemeInterface');
        Theme::themeSet($mock_theme);
        $result = Theme::themeGet();
        $this->assertEquals($mock_theme, $result);
    }
    
    public function testSetThemeByThemeName()
    {
        $mock_theme = Mockery::mock('Toiee\haik\Themes\ThemeInterface');
        $mock_repo = Mockery::mock('Toiee\haik\Themes\ThemeRepositoryInterface');
        $mock_repo->shouldReceive('get')->andReturn($mock_theme);
        $manager = App::make('ThemeManager');
        $manager->themes = $mock_repo;

        Theme::themeSet('kawaz');
        $result = Theme::themeGet();
        $this->assertInstanceOf('Toiee\haik\Themes\ThemeInterface', $result);

    }
}