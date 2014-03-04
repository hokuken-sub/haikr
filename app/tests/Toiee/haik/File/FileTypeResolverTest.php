<?php

use Toiee\haik\File\FileTypeResolver;

class FileTypeResolverTest extends TestCase {

    public function setUp()
    {
        $this->resolver = new FileTypeResolver;
    }

    public function testGetFileTypeByContent()
    {
        $this->markTestIncomplete('This interface not difined return type');

        $url = 'http://placehold.jp/150x150.png';
        $content = file_get_contents($url);
        $result = $this->resolver->getTypeByContents($content);
        
        $this->assertEquals('', $result);
    }

    public function testGetFileTypeByUrl()
    {
        $this->markTestIncomplete('This interface not difined return type');

        $url = 'http://placehold.jp/150x150.png';
        $result = $this->resolver->getTypeByLocation($url);

        $this->assertEquals('', $result);
    }

    public function testGetFileTypeByPath()
    {
        $this->markTestIncomplete('This interface not difined return type');

        $url = 'http://placehold.jp/150x150.png';
        $content = file_get_contents($url);
        $file_name = tempnam(sys_get_temp_dir(), 'haikr-test-');
        file_put_contents($file_name, $content);
        $result = $this->resolver->getTypeByLocation($file_name);
        unlink($file_name);
        
        $this->assertEquals('application/octet-stream', $result);
    }

    public function testGetFileNonExistance()
    {
        $path = './akrjgjanbmakrk7allak';
        $result = $this->resolver->getTypeByLocation($path);
        $this->assertEquals('application/octet-stream', $result);
    }

    public function testGetFileByEmptyContent()
    {
        $content = '';
        $result = $this->resolver->getTypeByContent($content);
        $this->assertEquals('application/octet-stream', $result);
    }
}