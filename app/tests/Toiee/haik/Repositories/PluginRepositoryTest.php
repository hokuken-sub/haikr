<?php

use Toiee\haik\Repositories\PluginRepository;
//use Config;

class PluginRepositoryTest extends TestCase {

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
        $this->assertInstanceOf('Toiee\haik\Plugins\Deco\DecoPlugin', $obj);
    }
    
    public function testLoadMultiply()
    {
        $repository = new PluginRepository;
        $obj = $repository->load('deco');
        $obj2 = $repository->load('deco');
    }

}
