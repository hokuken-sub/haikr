<?php
use Toiee\haik\File\FileRepository;

class FileRepositoryTest extends TestCase {

    public function setUp()
    {
        parent::setUp();

        $this->files = new FileRepository('SiteFile');
        $this->siteId = \Haik::getID();

        $this->seedFiles();
    }

    public function seedFiles()
    {
        SiteFile::truncate();

        $file1 = new SiteFile;
        $file1->haik_site_id = $this->siteId;
        $file1->key     = 'HgHg';
        $file1->type    = 'file';
        $file1->size    = '1024';
        $file1->ext     = 'ext';
        $file1->storage = 'local';
        $file1->save();
        
        $file2 = new SiteFile;
        $file2->haik_site_id = $this->siteId;
        $file2->key     = 'FgFg';
        $file2->type    = 'file';
        $file2->size    = '2048';
        $file2->ext     = 'ext';
        $file2->storage = 'local';
        $file2->save();
    }

    public function tearDown()
    {
        parent::tearDown();
        SiteFile::truncate();
    }

    public function testListGet()
    {
        $list = $this->files->listGet();
        // test return Collection
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $list);

        // test list data
        $newest_file = SiteFile::where("haik_site_id", $this->siteId)->orderBy("updated_at", "desc")->first();
        $this->assertEquals($newest_file, $list->first());
    }

    public function testListByType()
    {
        $list = $this->files->listByType("file");
        // test return Collection
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $list);

        // test list data
        $newest_file = SiteFile::where("haik_site_id", $this->siteId)->where("type", "file")
                           ->orderBy("updated_at", "desc")->first();
        $this->assertEquals($newest_file, $list->first());
    }

    public function testListStarred()
    {
        $list = $this->files->listStarred();
        // test return Collection
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $list);

        // test list data
        $newest_file = SiteFile::where("haik_site_id", $this->siteId)->where("starred", 1)
                           ->orderBy("updated_at", "desc")->first();
        $this->assertEquals($newest_file, $list->first());
    }

    public function testExists()
    {
        $file = SiteFile::where("haik_site_id", $this->siteId)
                           ->orderBy("updated_at", "desc")->first();
        $idenfier = $file->getIdentifier();
        $this->assertTrue($this->files->exists($idenfier));
    }

    public function testRetrieve()
    {
        $file = SiteFile::where("haik_site_id", $this->siteId)
                           ->orderBy("updated_at", "desc")->first();
        $idenfier = $file->getIdentifier();
        $this->assertEquals($file, $this->files->retrieve($idenfier));
    }

    public function testFactory()
    {
        $identifier = 'foobar';
        $file = $this->files->factory($identifier);
        $this->assertInstanceOf('Toiee\haik\File\FileInterface', $file);
        $this->assertEquals($identifier, $file->getIdentifier());
    }
}