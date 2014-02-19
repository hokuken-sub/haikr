<?php
use Toiee\haik\Link\LinkInterface;
use Toiee\haik\Link\Link;

class LinkTest extends TestCase {
    
    public $link;
    
    public function setUp()
    {
        parent::setUp();
        
        App::bind('LinkInterface',function(){
            return new Link;
        });

        $this->link = App::make('LinkInterface');
                
    }
    
    public function testGetFrontPageURL()
    {
        $result = $this->link->url('FrontPage');
        $this->assertEquals(Config::get('app.url'), $result);
    }

    public function testGetFrontPageURLWithHash()
    {
        $result = $this->link->url('FrontPage#test');
        $this->assertEquals(Config::get('app.url').'/#test', $result);
    }

    public function testGetPageURL()
    {
        $result = $this->link->url('Contact');
        $this->assertEquals(Config::get('app.url').'/Contact', $result);
    }

    public function testGetPageURLWithHash()
    {
        $result = $this->link->url('Contact#test');
        $this->assertEquals(Config::get('app.url').'/Contact#test', $result);
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
    
}