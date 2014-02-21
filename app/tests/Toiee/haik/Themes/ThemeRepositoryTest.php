<?php 

use Toiee\haik\Themes\ThemeRepository;

class ThemeRepositoryTest extends TestCase {
    
    public function setUp()
    {
        App::bind('ThemeRepositoryInterface', 'Toiee\haik\Themes\ThemeRepository');
    }
    
    public function testGet()
    {
        $repository = App::make('ThemeRepositoryInterface');
        $result = $repository->get();
        $this->assertInstanceOf('Toiee\haik\Themes\ThemeInterface', $result);
    }
    
    public function testGetAll()
    {
        $repository = App::make('ThemeRepositoryInterface');
        $result = $repository->getAll();
        $this->assertInternalType('array', $result);
    }

    public function testExistsTheme()
    {
        $repository = App::make('ThemeRepositoryInterface');
        $result = $repository->exists('kawaz');
        $this->assertFalse($result);
    }

}