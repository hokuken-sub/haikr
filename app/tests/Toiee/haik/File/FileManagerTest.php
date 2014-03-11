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
        $file->haik_site_id = \Haik::getID();
        $file->type = 'file';
        $file->storage = 'local';
        $file2 = with(new SiteFile())->setIdentifier($this->fname . '_copied');
        $file2->haik_site_id = \Haik::getID();
        $file2->type = 'file';
        $file2->storage = 'local';

        App::bind('FileRepositoryInterface', function() use ($file, $file2)
        {
            $mock = Mockery::mock('Toiee\haik\File\FileRepositoryInterface');
            $mock->shouldReceive('retrieve')->andReturn($file);
            $mock->shouldReceive('exists')->andReturn(true);
            $mock->shouldReceive('copy')->andReturn($file2);
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
        \SiteFile::truncate();

        File::deleteDirectory(\Config::get("file.local.path") . \Haik::getID());
    }

    public function testSetLastSaved()
    {
        $this->manager->fileSave($this->file);
        $this->assertEquals($this->file, $this->manager->getLastSaved());
    }

    public function testFileDelete()
    {
        $this->manager->fileSave($this->file);
        $result = $this->manager->fileDelete($this->fname);
        $this->assertTrue($result);
        $this->assertFalse(\File::exists($this->fpath));
    }
    public function testFileCopy()
    {
        return;
        \File::put($this->fpath, $this->fileContent);
        $copied_file = $this->manager->fileCopy($this->fname);
        $content = $this->manager->fileGetContent($copied_file->getIdentifier());
        $this->assertEquals($this->fileContent, $content);
    }
    public function testFileGetContent()
    {
        \File::put($this->fpath, $this->fileContent);
        $content = $this->manager->fileGetContent($this->file->getIdentifier());
        $this->assertEquals($this->fileContent, $content);
    }

    public function testImageGet()
    {
        $file = with(new SiteFile())->setIdentifier($this->fname);
        $file->haik_site_id = \Haik::getID();
        $file->type = 'image';
        $file->storage = 'local';
        
        App::bind('FileRepositoryInterface', function() use ($file)
        {
            return Mockery::mock(
                                'Toiee\haik\File\FileRepositoryInterface',
                                function($mock) use ($file)
                                {
                                    $mock->shouldReceive('exists')->andReturn(true);
                                    $mock->shouldReceive('retrieve')->andReturn($file);
                                    return $mock;
                                });
        });
        $manager = new FileManager(App::make('FileRepositoryInterface'));

        $result = $manager->imageGet($this->fname);
        $this->assertInstanceOf('Toiee\haik\File\FileInterface', $result);
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

    public function testUrlSaveAsFile() {
        $this->markTestIncomplete('Waiting db storage');

        $url = 'http://www.google.com/';
        $this->manager->urlSaveAsFile($url);
        $file = $this->manager->getLastSaved();
        $content = $this->manager->fileGetContent($file->getIdentifier());
        $this->assertEquals($url, $content);
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

    public function testSaveUploaded()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    public function testSaveByUrl()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

}
