<?php

class RouteTest extends TestCase {
    
    function testShowPage()
    {
		$crawler = $this->client->request('GET', 'Contact.html');
        $this->assertTrue($this->client->getResponse()->isOk());
        $this->assertViewHas('content');
    }
    
    /**
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    function testShowPageWithoutExtThrowsException()
    {
		$crawler = $this->client->request('GET', 'Contact');
    }
    
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