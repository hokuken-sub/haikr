<?php

use Toiee\haik\File\LocalStorage;

class LocalStorageTest extends TestCase {

    public $fname = 'AnPnMn.jpg';
    public $fpath;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->fpath = \Config::get("file.local.path") . \Haik::getID() . '/'.$this->fname;

        App::bind('FileInterface', function()
        {
            $mock = Mockery::mock('Toiee\haik\File\FileInterface');

            $mock->shouldReceive('getName')
                 ->once()
                 ->andReturn($this->fname);

            return $mock;
        });

        File::makeDirectory(\Config::get("file.local.path") . \Haik::getID(), 511, false, true);

    }
    
    public function tearDown()
    {
        $file = App::make('FileInterface');
        $storage = new LocalStorage;
        
        if (file_exists($this->fpath))
        {
            unlink($this->fpath);
        }

        File::deleteDirectory(\Config::get("file.local.path") . \Haik::getID());
    }

    public function testExists()
    {
        $file = App::make('FileInterface');
        $storage = new LocalStorage;

        file_put_contents($this->fpath, 'abcdefg');
        
        $this->assertTrue($storage->exists($file));
    }

    public function testNotExists()
    {
        $file = App::make('FileInterface');
        $storage = new LocalStorage;
        
        $this->assertFalse($storage->exists($file));
    }
    
    /**
     * @expectedException Illuminate\Filesystem\FileNotFoundException
     */
    public function testGetFileNotFoundException()
    {

        $file = App::make('FileInterface');
        $storage = new LocalStorage;
        
        $data = $storage->get($file);
    }
    
    
    public function testGet()
    {
        file_put_contents($this->fpath, 'abcdefg');

        $file = App::make('FileInterface');
        $storage = new LocalStorage;
        
        $this->assertEquals(file_get_contents($this->fpath), $storage->get($file));
    }    

    public function testSave()
    {
        $file = App::make('FileInterface');
        $storage = new LocalStorage;
        
        $content = time();
        $storage->save($file, $content);

        $this->assertEquals($content, $storage->get($file));
    }
    
    
    public function testDelete()
    {
        $file = App::make('FileInterface');
        $storage = new LocalStorage;
        
        $content = time();
        $storage->save($file, $content);
        
        $storage->delete($file);
        
        $this->assertFalse($storage->exists($file));
        
    }
    
    public function testCopy()
    {
        $file = App::make('FileInterface');
        $storage = new LocalStorage;

        $content = time();
        $storage->save($file, $content);

        $dest_id = 'panini.png';
        $storage->copy($file, $dest_id);
        
        $this->assertEquals($content, file_get_contents(dirname($this->fpath).'/'.$dest_id));
    }

    public function testDownload()
    {
        $this->markTestIncomplete('I cannot find how to test!');
    }

    public function testPassthru()
    {
        $this->markTestIncomplete('I cannot find how to test!');
    }    

}