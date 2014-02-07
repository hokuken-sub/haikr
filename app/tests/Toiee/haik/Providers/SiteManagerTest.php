<?php
use Toiee\haik\Providers\SiteManager;

class SiteManagerTest extends TestCase {
    
    public function testFacade()
    {
        $this->assertInternalType('array', Haik::pages());
    }
    
    public function testGet()
    {
        $site = Site::find(1);
        $this->assertEquals($site->title, Haik::get('title'));
    }

    public function testSave()
    {
        $result = Haik::save('title', '20 x pen');
        $this->assertEquals('20 x pen', Haik::get('title'));
        $this->assertTrue($result);
    }

    public function testAllPages()
    {
        $pages = Haik::pages(true);
//        dd($pages);
    }

    public function testPages()
    {
        $pages = Haik::pages(false);      
//        dd($pages);
    }


    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetThrowsExceptionWhenNotExists()
    {
        // should throws exception
        Haik::get('abc');
    }

}