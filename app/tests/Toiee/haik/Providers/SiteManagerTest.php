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

    public function testValidatePageName()
    {
        $validationRules = array(
            'none' => array(
                'pagename' => '',
                'return' => false
            ),
            'top' => array(
                'pagename' => 'FrontPage',
                'return' => true
            ),
            'url' => array(
                'pagename' => 'http://hokuken.com',
                'return' => false
            ),
            'slash' => array(
                'pagename' => 'Page/name',
                'return' => false
            ),
            'mb' => array(
                'pagename' => 'わはは',
                'return' => true
            ),
            'return' => array(
                'pagename' => "あ\nい",
                'return' => false
            ),
            'end_return' => array(
                'pagename' => "あう\n",
                'return' => false
            ),
            'tab' => array(
                'pagename' => "a\tbc",
                'return' => false
            ),
            'end_tab' => array(
                'pagename' => "abc\t",
                'return' => false
            ),
            'space_first' => array(
                'pagename' => " abc",
                'return' => false
            ),
            'name_in_limit' => array(
                'pagename' => str_pad("",255, 'a'),
                'return' => true
            ),
            'name_over_limit' => array(
                'pagename' => str_pad("",256, 'b'),
                'return' => false
            ),
        );
        
        foreach ($validationRules as $rule)
        {
            $result = Haik::validatePageName($rule['pagename']);
            if ($rule['return'])
            {
                $this->assertTrue($result);
            }
            else
            {
                $this->assertFalse($result);
            }
        }
    }

}