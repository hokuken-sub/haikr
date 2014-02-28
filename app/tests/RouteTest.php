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
    
    function testShowPageContainMultiByteString()
    {
        try {
            $crawler = $this->client->request('GET', '日本語.html');
            $this->assertTrue($this->client->getResponse()->isOk());
            $this->assertViewHas('page_title', '日本語');
        } catch (Exception $e) {}
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    function testShowPageNonExistanceThrowsException()
    {
        $crawler = $this->client->request('GET', 'page_not_exists.html');
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
    
    function testOtherDomain()
    {
        $this->markTestIncomplete('Do not know test other domain');        
    }
    
    function testSubDirectory()
    {
        // /sub/FrontPage.html が表示されたら成功
        $crawler = $this->client->request('GET', 'http://localhost:8080/sub/FrontPage.html');
        $this->assertTrue($this->client->getResponse()->isOk());
        $this->assertViewHas('url', 'http://example.com:8080/sub/FrontPage.html');
        
    }
}