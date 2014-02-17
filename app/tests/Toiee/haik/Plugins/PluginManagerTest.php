<?php
use Toiee\haik\Plugins\PluginManager;

class PluginManagerTest extends TestCase {
    
    public function testFacade()
    {
        App::bind('PluginInterface', function()
        {
            $mock = Mockery::mock('Toiee\haik\Plugins\PluginInterface');
            return $mock;
        });

        App::bind('PluginRepositoryInterface', function(){
            $mock = Mockery::mock('Toiee\haik\Plugins\PluginRepositoryInterface');
            $mock->shouldReceive('exists')
                 ->once()
                 ->andReturn(true);
            $mock->shouldReceive('load')
                 ->once()
                 ->andReturn(App::make('PluginInterface'));
            return $mock;
        });

        $this->assertInstanceOf('Toiee\haik\Plugins\PluginInterface', Plugin::get('deco'));
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetThrowsExceptionWhenExists()
    {
        // mock a repository
        App::bind('PluginRepositoryInterface', function(){
            $mock = Mockery::mock('Toiee\haik\Plugins\PluginRepositoryInterface');
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
        App::bind('PluginInterface', function()
        {
            $mock = Mockery::mock('Toiee\haik\Plugins\PluginInterface');
            return $mock;
        });

        App::bind('PluginRepositoryInterface', function()
        {
            $mock = Mockery::mock('Toiee\haik\Plugins\PluginRepositoryInterface');
            $mock->shouldReceive('exists')
                 ->once()
                 ->andReturn(true);
            $mock->shouldReceive('load')
                 ->once()
                 ->andReturn(App::make('PluginInterface'));
            return $mock;
        });
        
        $plugin = Plugin::get('abc');
        $this->assertInstanceOf('Toiee\haik\Plugins\PluginInterface', $plugin);
    }
    
    public function testAllPluginsReturnsArray()
    {
        App::bind('PluginRepositoryInterface', function()
        {
            $mock = Mockery::mock('Toiee\haik\Plugins\PluginRepositoryInterface');
            $mock->shouldReceive('getAll')
                 ->once()
                 ->andReturn(array());
            return $mock;
        });
        
        $plugins = Plugin::allPlugins();
        $this->assertInternalType('array', $plugins);
    }
    
}