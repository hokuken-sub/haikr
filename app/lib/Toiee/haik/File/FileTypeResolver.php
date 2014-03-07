<?php
namespace Toiee\haik\File;

class FileTypeResolver {

    const DEFAULT_TYPE = 'file';

    protected $fileTypeConvertTable = array(
        // image: this type is editable
        'image/jpeg' => 'image',
        'image/jpeg' => 'image',
        'image/jp2'  => 'image',
        'image/png'  => 'image',
        'image/gif'  => 'image',
        'image/bmp'  => 'image',

        // audio: this type
        'audio/mpeg'         => 'audio',
        'audio/x-wav'        => 'audio',
        'audio/midi'         => 'audio',
        'audio/midi'         => 'audio',
        'application/x-smaf' => 'audio',

        // video
        'audio/mp4'      => 'video',
        'video/mpeg'     => 'video',
        'video/mpeg'     => 'video',
        'video/x-ms-wmv' => 'video',
        'video/3gpp2'    => 'video',

        // doc
        'application/msword'                  => 'doc',
        'application/vnd.ms-excel'            => 'doc',
        'application/vnd.ms-powerpoint'       => 'doc',
        'application/pdf'                     => 'doc',
        'application/vnd.fujixerox.docuworks' => 'doc',
        'text/html'                           => 'doc',
        'text/x-hdml'                         => 'doc',

        // link
        'text/x-haik-link' => 'link',

        // archive
        'application/zip'   => 'archive',
        'application/x-lzh' => 'archive',
        'application/x-lzh' => 'archive',
        'application/x-tar' => 'archive',
        'application/x-tar' => 'archive',
        
        // other files
        'application/postscript'        => 'file',
        'text/plain'                    => 'file',
        'text/csv'                      => 'file',
        'text/tab-separated-values'     => 'file',
        'text/css'                      => 'file',
        'text/javascript'               => 'file',
        'application/x-shockwave-flash' => 'file',
    );

    /**
     * Get haik-file-type from mime-type
     *
     * @param string mime-type
     * @return string haik-file-type
     */
    public function getType($mime_type)
    {
        list($mime_type, $charset) = $this->parseMimeType($mime_type);
        if (isset($this->fileTypeConvertTable[$mime_type]))
        {
            return $this->fileTypeConvertTable[$mime_type];
        }
        else
        {
            return self::DEFAULT_TYPE;
        }
    }

    /**
     * Parse mime-type string to mime-type and charset.
     * `application/json; charset=utf-8` => `[application/json, utf-8]`
     *
     * @param string $mime_type
     * @return array [mime-type, charset]
     */
    public function parseMimeType($mime_type)
    {
        $parsed_mime_type = array_pad(explode(';', $mime_type, 2), 2, '');
        
        if (trim($parsed_mime_type[1]) !== '')
        {
            $parsed_mime_type[1] = preg_match('/^\s*charset=([^ ]+)/', $parsed_mime_type[1], $mts) ? $mts[1] : '';
        }
        
        return $parsed_mime_type;
    }

}
