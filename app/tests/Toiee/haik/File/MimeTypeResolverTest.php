<?php

use Toiee\haik\File\MimeTypeResolver;

class MimeTypeResolverTest extends TestCase {

    public function setUp()
    {
        $this->resolver = new MimeTypeResolver;
    }

    public function testGetMimeTypeByContent()
    {
        $url = 'http://placehold.jp/150x150.png';
        $content = file_get_contents($url);
        $result = $this->resolver->getTypeByContent($content);
        
        $this->assertTrue(starts_with($result, 'image/png'));
    }

    public function testGetHaikLink()
    {
        $content = 'http://www.google.com/';
        $expected = 'text/x-haik-link';
        $result = $this->resolver->getTypeByContent($content);
        $this->assertEquals($expected, $result);
    }

    public function testGetMimeTypeByUrl()
    {
        $url = 'http://placehold.jp/150x150.png';
        $result = $this->resolver->getTypeByLocation($url);

        $this->assertTrue(starts_with($result, 'image/png'));
    }

    public function testGetMimeTypeByPath()
    {
        $url = 'http://placehold.jp/150x150.png';
        $content = file_get_contents($url);
        $file_name = tempnam(sys_get_temp_dir(), 'haikr-test-');
        file_put_contents($file_name, $content);
        $result = $this->resolver->getTypeByLocation($file_name);
        unlink($file_name);
        
        $this->assertTrue(starts_with($result, 'image/png'));
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