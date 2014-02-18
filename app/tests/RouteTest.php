<?php

class RouteTest extends TestCase {
    
    function testCallActionPlugin()
    {
        App::bind('PluginInterface', function()
        {
            $mock = Mockery::mock('Toiee\haik\Plugins\PluginInterface');
            $mock->shouldReceive('action')
                 ->andReturn('action plugin was called.');
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
		$crawler = $this->client->request('GET', 'haik--plugin');

		$this->assertTrue($this->client->getResponse()->isOk());
		$this->assertViewHas('content');
    }
}