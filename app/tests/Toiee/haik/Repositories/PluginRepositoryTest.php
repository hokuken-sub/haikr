<?php

use Toiee\haik\Repositories\PluginRepository;
//use Config;

class PluginRepositoryTest extends TestCase {

    public function testExistsReturnsFalseWhenPluginNotExists()
    {
        $repository = App::make('PluginRepositoryInterface');
        $result = $repository->exists('abc');
        $this->assertFalse($result);
    }

    public function testExistsReturnsTrueWhenPluginExists()
    {
        $repository = App::make('PluginRepositoryInterface');
        $result = $repository->exists('deco');
        $this->assertTrue($result);
    }
    
    public function testLoadReturnsType()
    {
        $repository = App::make('PluginRepositoryInterface');
        $obj = $repository->load('deco');
        $this->assertInstanceOf('Toiee\haik\Plugins\Deco\DecoPlugin', $obj);
    }
    
    public function testLoadMultiply()
    {
        $repository = App::make('PluginRepositoryInterface');
        $obj = $repository->load('deco');
        $obj2 = $repository->load('deco');
    }

}
