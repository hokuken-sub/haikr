<?php
use Toiee\haik\File\FileRepository;

class FileRepositoryTest extends TestCase {

    public function setUp()
    {
        $this->files = new FileRepository('SiteFile');
        $this->siteId = \Haik::getID();
    }

    public function testListGet()
    {
        $this->markTestIncomplete('This test needs File model');
        
        $list = $this->files->listGet();
        // test return Collection
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $list);
        
        // test list data
        $newest_file = SiteFile::where("haik_site_id", $this->siteId)->orderBy("updated_at", "desc")->first();
        $this->assertEquals($newest_file, $list->first());
    }
    
    public function testListByType()
    {
        $this->markTestIncomplete('This test needs File model');

        $list = $this->files->listByType("image");
        // test return array
        $this->assertInternalType('array', $list);
        
        // test list data
        $newest_file = SiteFile::where("haik_site_id", $this->siteId)->where("type", "image")
                           ->orderBy("updated_at", "desc")->first();
        $this->assertEquals($newest_file, $list->first());
    }
    
    public function testListStarred()
    {
        $list = $this->files->listByType("image");
        // test return Collection
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $list);
        
        // test list data
        $newest_file = SiteFile::where("haik_site_id", $this->siteId)->where("starred", 1)
                           ->orderBy("updated_at", "desc")->first();
        $this->assertEquals($newest_file, $list->first());
    }
    
    public function testExists()
    {
        $this->markTestIncomplete('This test needs File model');

        $file = SiteFile::where("haik_site_id", $this->siteId)
                           ->orderBy("updated_at", "desc")->first();
        $idenfier = $file->key;
        $this->assertTrue($this->files->exists($idenfier));
    }
    
    public function testRetrieve()
    {
        $this->markTestIncomplete('This test needs File model');
        
        $file = SiteFile::where("haik_site_id", $this->siteId)
                           ->orderBy("updated_at", "desc")->first();
        $idenfier = $file->key;
        $this->assertEquals($this->files->retrieve($idenfier));
    }

}