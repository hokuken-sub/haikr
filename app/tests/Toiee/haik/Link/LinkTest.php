<?php
use Toiee\haik\Link\LinkInterface;
use Toiee\haik\Link\Link;
use Toiee\haik\Link\PageResolver;

class LinkTest extends TestCase {
    
    public $link;
    public $site;
    
    public function setUp()
    {
        parent::setUp();
        
        App::bind('SiteManager', function(){
            $mock = Mockery::mock('Toiee\haik\Providers\SiteManager');
            $mock->shouldReceive('url')
                ->andReturn(str_finish(Config::get('app.url'), '/'));
                
            return $mock;
        });
        $this->site = App::make('SiteManager');
        
        App::bind('LinkInterface',function(){
            return new Link(
                array(
                    new PageResolver
                )
            );
        });
        $this->link = App::make('LinkInterface');
    }
    
    public function testGetFrontPageURL()
    {
        $result = $this->link->url('FrontPage');
        $this->assertEquals($this->site->url(), $result);
    }

    public function testGetFrontPageURLWithHash()
    {
        $result = $this->link->url('FrontPage#test');
        $this->assertEquals($this->site->url().'#test', $result);
    }

    public function testGetPageURL()
    {
        $result = $this->link->url('Contact');
        $this->assertEquals($this->site->url().'Contact', $result);
    }

    public function testGetPageURLWithHash()
    {
        $result = $this->link->url('Contact#test');
        $this->assertEquals($this->site->url().'Contact#test', $result);
    }

    public function testGetHash()
    {
        $result = $this->link->url('#test');
        $this->assertEquals('#test', $result);
    }
    
    public function testGetUrl()
    {
        $result = $this->link->url('http://google.com');
        $this->assertEquals('http://google.com', $result);
    }

    public function testGetBarbaroi()
    {
        $result = $this->link->url('Barbaroi');
        $this->assertEquals('Barbaroi', $result);
    }
    
    
    
}