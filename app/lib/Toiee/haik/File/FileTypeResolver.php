<?php
namespace Toiee\haik\File;

class FileTypeResolver {
    use ConvertTable;

    const DEFAULT_HAIK_FILE_TYPE = 'file';

    /**
     * Get haik-file-type from mime-type
     *
     * @param string mime-type
     * @return string haik-file-type
     */
    public function getType($mime_type)
    {
        list($mime_type, $charset) = $this->parseMimeType($mime_type);
        if (isset($this->mimeTypeToHaikFileType[$mime_type]))
        {
            return $this->mimeTypeToHaikFileType[$mime_type];
        }
        else
        {
            return self::DEFAULT_HAIK_FILE_TYPE;
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
