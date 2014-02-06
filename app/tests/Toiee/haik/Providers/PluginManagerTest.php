<?php
use Toiee\haik\Providers\PluginManager;

class PluginManagerTest extends TestCase {
    
    public function testImATeapot()
    {
        $obj = new PluginManager;
        $this->assertEquals($obj->imATeapot(), "I'm a teapot.");
    }
    
    public function testFacade()
    {
        $this->assertEquals(Plugin::imATeapot(), "I'm a teapot.");
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetThrowsExceptionWhenExists()
    {
        // mock a repository
        App::bind('PluginRepositoryInterface', function(){
            $mock = Mockery::mock('Toiee\haik\Repositories\PluginRepositoryInterface');
            $mock->shouldReceive('exists')
                 ->once()
                 ->andReturn(false);
            return $mock;
        });
        
        // should throws exception
        Plugin::get('abc');
    }
    
    public function testGet()
    {
        App::bind('PluginRepositoryInterface', function()
        {
            $mock = Mockery::mock('Toiee\haik\Repositories\PluginRepositoryInterface');
            $mock->shouldReceive('exists')
                 ->once()
                 ->andReturn(true);
            $mock->shouldReceive('load')
                 ->once()
                 ->andReturn(App::make('PluginInterface'));
            return $mock;
        });
        
        App::bind('PluginInterface', function()
        {
            $mock = Mockery::mock('Toiee\haik\Entities\PluginInterface');
            return $mock;
        });
        
        $plugin = Plugin::get('abc');
        $this->assertInstanceOf('Toiee\haik\Entities\PluginInterface', $plugin);
    }
    
    public function testAllPluginsReturnsArray()
    {
        App::bind('PluginRepositoryInterface', function()
        {
            $mock = Mockery::mock('Toiee\haik\Repositories\PluginRepositoryInterface');
            $mock->shouldReceive('getAll')
                 ->once()
                 ->andReturn(array());
            return $mock;
        });
        
        $plugins = Plugin::allPlugins();
        $this->assertInternalType('array', $plugins);
    }
    
}