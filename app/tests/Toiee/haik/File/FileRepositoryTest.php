<?php
use Toiee\haik\File\FileRepository;
use File;

class FileRepositoryTest extends TestCase {

    public function setUp()
    {
        $this->files = new FileRepository('File');
//        $this->siteId = Haik::getID();
    }

    public function testListGet()
    {
        $this->markTestIncomplete('This test needs File model');
        
        $list = $this->files->listGet();
        // test return array
        $this->assertInternalType('array', $list);
        
        // test list data
        $newest_file = File::where("haik_site_id", $this->siteId)->orderBy("updated_at", "desc")->first();
        $this->assertEquals($newest_file, $list[0]);
    }
    
    public function testListByType()
    {
        $this->markTestIncomplete('This test needs File model');

        $list = $this->files->listByType("image");
        // test return array
        $this->assertInternalType('array', $list);
        
        // test list data
        $newest_file = File::where("haik_site_id", $this->siteId)->where("type", "image")
                           ->orderBy("updated_at", "desc")->first();
        $this->assertEquals($newest_file, $list[0]);
    }
    
    public function testListStarred()
    {
        $list = $this->files->listByType("image");
        // test return array
        $this->assertInternalType('array', $list);
        
        // test list data
        $newest_file = File::where("haik_site_id", $this->siteId)->where("starred", 1)
                           ->orderBy("updated_at", "desc")->first();
        $this->assertEquals($newest_file, $list[0]);
    }
    
    public function testExists()
    {
        $this->markTestIncomplete('This test needs File model');

        $file = File::where("haik_site_id", $this->siteId)
                           ->orderBy("updated_at", "desc")->first();
        $idenfier = $file->key;
        $this->assertTrue($this->files->exists($idenfier));
    }
    
    public function testRetrieve()
    {
        $this->markTestIncomplete('This test needs File model');
        
        $file = File::where("haik_site_id", $this->siteId)
                           ->orderBy("updated_at", "desc")->first();
        $idenfier = $file->key;
        $this->assertEquals($this->files->retrieve($idenfier));
    }

}