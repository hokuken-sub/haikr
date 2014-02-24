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
        Theme::themeSet('kawaz');
        $result = Theme::themeGet();
        $this->assertInstanceOf('Toiee\haik\Themes\ThemeInterface', $result);
    }
}