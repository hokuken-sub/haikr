<?php

use Toiee\haik\File\FileTypeResolver;

class FileTypeResolverTest extends TestCase {

    public function setUp()
    {
        $this->resolver = new FileTypeResolver();
    }

    public function testParseMimeType()
    {
        $mime_type = 'text/plain; charset=us-ascii';
        $expected = array(
            'text/plain',
            'us-ascii'
        );
        
        $result = $this->resolver->parseMimeType($mime_type);
        $this->assertEquals($expected, $result);
    }
    
    /**
     * @dataProvider mimeTypeProvider
     */
    public function testGetType($mime_type, $expected)
    {
        $type = $this->resolver->getType($mime_type);
        $this->assertEquals($expected, $type);
    }

    public function testGetTypeWithCharset()
    {
        $mime_type_has_charset = 'image/jpeg; charset=binary';
        $expected = 'image';
        $type = $this->resolver->getType($mime_type_has_charset);
        $this->assertEquals($expected, $type);
    }
    
    public function mimeTypeProvider()
    {
        return array(
            'pdf_to_doc' => array(
                'mime_type' => 'application/pdf',
                'expected'  => 'doc',
            ),
            'mp3_to_audio' => array(
                'mime_type' => 'audio/mpeg',
                'expected'  => 'audio',
            ),
            'png_to_image' => array(
                'mime_type' => 'image/png',
                'expected'  => 'image',
            ),
            'mp4_to_video' => array(
                'mime_type' => 'audio/mp4',
                'expected'  => 'video',
            ),
            'other_to_file' => array(
                'mime_type' => 'plain/text',
                'expected'  => 'file',
            )
        );
    }
}
