<?php 

use Toiee\haik\Themes\ThemeRepository;

class ThemeRepositoryTest extends TestCase {
    
    public function setUp()
    {
        App::bind('ThemeRepositoryInterface', 'Toiee\haik\Themes\ThemeRepository');
    }

    public function testGetWhenThereIsNoTheme()
    {
        $repository = App::make('ThemeRepositoryInterface');

        try
        {
            $result = $repository->get('hoge');
        }
        catch (InvalidArgumentException $expected)
        {
            return;
        }
        
        $this->fail('There is no error expected.');
    }
    
    public function testGet()
    {
        $repository = App::make('ThemeRepositoryInterface');

        try
        {
            $result = $repository->get('kawaz');
            $this->assertInstanceOf('Toiee\haik\Themes\ThemeInterface', $result);
        }
        catch (InvalidArgumentException $expected)
        {
            $this->markTestIncomplete(
              'testGet: test not yet exists theme.'
            );
            return;
        }
    }
    
    public function testGetAll()
    {
        $repository = App::make('ThemeRepositoryInterface');
        $result = $repository->getAll();
        $this->assertInternalType('array', $result);
        
        $this->markTestIncomplete(
          'testGetAll: get all method is not completed.'
        );
    }

    public function testExistsTheme()
    {
        $repository = App::make('ThemeRepositoryInterface');
        $result = $repository->exists('kawaz');
        $this->assertFalse($result);
    }

}