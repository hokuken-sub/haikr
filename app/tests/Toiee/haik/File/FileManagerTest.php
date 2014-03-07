<?php

use Toiee\haik\File\FileManager;
use Toiee\haik\File\FileRepository;

class FileManagerTest extends TestCase {

    protected $fname = 'HgHg';
    protected $manager;

    public function setUp()
    {
        parent::setUp();
        
        $this->fileContent = microtime();
        $this->fpath = \Config::get("file.local.path") . \Haik::getID() . '/'.$this->fname;

        File::makeDirectory(\Config::get("file.local.path") . \Haik::getID(), 511, false, true);

        \File::put($this->fpath, $this->fileContent);

        $file = with(new SiteFile())->setIdentifier($this->fname);

        App::bind('FileRepositoryInterface', function() use ($file)
        {
            $mock = Mockery::mock('Toiee\haik\File\FileRepositoryInterface');
            $mock->shouldReceive('retrieve')->andReturn($file);
            $mock->shouldReceive('exists')->andReturn(true);
            return $mock;
        });

        $this->file = $file;
        $this->manager = App::make('FileManager');
    }

    public function tearDown()
    {
        if (file_exists($this->fpath))
        {
            unlink($this->fpath);
        }

        File::deleteDirectory(\Config::get("file.local.path") . \Haik::getID());
    }
    public function testFileGetContent()
    {
        \File::put($this->fpath, $this->fileContent);
        $content = $this->manager->fileGetContent($this->file->getIdentifier());
        $this->assertEquals($this->fileContent, $content);
    }

    public function testFileSaveContent()
    {
        $file = $this->file;
        $file->haik_site_id = \Haik::getID();
        $file->type    = 'file';
        $file->size    = '1024';
        $file->original_name     = '';
        $file->storage = 'local';
        $file->save();

        $this->manager = new FileManager(new FileRepository('SiteFile'));

        $update_content = microtime();
        $this->manager->fileSaveContent($file, $update_content);
        $this->assertEquals(\File::get($this->fpath), $update_content);
    }

    /**
     * @expectedException Illuminate\Filesystem\FileNotFoundException
     */
    public function testFileDelete()
    {
        $this->manager->fileDelete($this->file->getIdentifier());
        \File::get($this->fpath);
    }

    public function testAccess()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    public function testDownload()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

}