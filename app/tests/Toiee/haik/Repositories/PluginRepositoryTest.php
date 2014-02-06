<?php

use Toiee\haik\Repositories\PluginRepository;
//use Config;

class PluginRepositoryTest extends TestCase {

    /**
     * @expectedException RuntimeException
     */
    public function testSetThrowsRuntimeExceptionIfPluginDirNotExists()
    {
        // set non-existent path for test
        Config::set('app.haik.plugin.folder', 'kgakejkjafakdkfjklehkjjkl');
        $repository = new PluginRepository;
    }

    public function testSetValidPathToPluginDir()
    {
        $repository = new PluginRepository;
        
        $this->assertEquals('public/addons/plugins/', $repository->getPath());
    }
    
    public function testExistsReturnsFalseWhenPluginNotExists()
    {
        $repository = new PluginRepository;
        $result = $repository->exists('abc');
        
        $this->assertFalse($result);
    }

    public function testExistsReturnsTrueWhenPluginExists()
    {
        $repository = new PluginRepository;
        $result = $repository->exists('deco');
        
        $this->assertTrue($result);
    }
    
    public function testLoadReturnsType()
    {
        $repository = new PluginRepository;
        $obj = $repository->load('deco');
        $this->assertInstanceOf('DecoPlugin', $obj);
    }
    
    public function testLoadMultiply()
    {
        $repository = new PluginRepository;
        $obj = $repository->load('deco');
        $obj2 = $repository->load('deco');
    }

}
