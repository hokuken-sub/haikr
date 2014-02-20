<?php
use Toiee\haik\Link\LinkInterface;
use Toiee\haik\Link\Link;
use Toiee\haik\Link\PageResolver;

class LinkTest extends TestCase {
    
    public $link;
    public $site;
    
    public function testFacade()
    {
        $url = \Link::url('Contact');
        $this->assertEquals(Haik::pageUrl('Contact'), $url);
    }
    
    public function testGetFrontPageURL()
    {
        $result = \Link::url('FrontPage');
        $this->assertEquals(Haik::url(), $result);
    }

    public function testGetFrontPageURLWithHash()
    {
        $result = \Link::url('FrontPage#test');
        $this->assertEquals(Haik::url().'#test', $result);
    }

    public function testGetPageURL()
    {
        $result = \Link::url('Contact');
        $this->assertEquals(Haik::url().'Contact.html', $result);
    }

    public function testGetPageURLWithHash()
    {
        $result = \Link::url('Contact#test');
        $this->assertEquals(Haik::url().'Contact.html#test', $result);
    }

    public function testGetHash()
    {
        $result = \Link::url('#test');
        $this->assertEquals('#test', $result);
    }
    
    public function testGetUrl()
    {
        $result = \Link::url('http://google.com');
        $this->assertEquals('http://google.com', $result);
    }

    public function testGetBarbaroi()
    {
        $result = \Link::url('Barbaroi');
        $this->assertEquals('Barbaroi', $result);
    }
}