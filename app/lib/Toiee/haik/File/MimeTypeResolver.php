<?php
namespace Toiee\haik\File;

class MimeTypeResolver {
    use ConvertTable;

    const DEFAULT_MIME_TYPE   = 'application/octet-stream';
    const HAIK_LINK_MIME_TYPE = 'text/x-haik-link';

    /**
     * Get File Type By Content
     *
     * @param $content file content data
     * @return string mime-type of the file
     */
    public function getTypeByContent($content)
    {
        if (strlen($content) === 0) return self::DEFAULT_MIME_TYPE;
        
        if ($this->isLink($content))
        {
            return self::HAIK_LINK_MIME_TYPE;
        }

        if (extension_loaded('finfo'))
        {
            $finfo = new finfo(FILEINFO_MIME);
            $mimetype = $finfo->buffer($content);
            return $mimetype;
        }
        else
        {
            $file_name = tempnam(sys_get_temp_dir(), 'haikr-file-type-');
            file_put_contents($file_name, $content);

            $result = $this->getTypeByLocation($file_name);

            unlink($file_name);
            return $result;
        }
    }

    /**
     * Get File Type By URL or path
     *
     * @param $location file URL or path
     * @return string mime-type of the file
     */
    public function getTypeByLocation($location)
    {
        if (extension_loaded('finfo'))
        {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimetype = $finfo->file($location);
            return $mimetype;
        }
        else
        {
            if (file_exists($location) OR $this->isLink($location))
            {
                $info = pathinfo($location);
                if (isset($info['extension']) && isset($this->extToMimeType[$info['extension']]))
                {
                    return $this->extToMimeType[$info['extension']];
                }
                else if ( ! file_exists('mime_content_type'))
                {
                    return exec('file -bI ' . $location);
                }
                else
                {
                    return mime_content_type($location);
                }
            }
            else
            {
                return self::DEFAULT_MIME_TYPE;
            }
        }
    }

    protected function isLink($content)
    {
        return preg_match('{^(?:https?|ftp)://}', $content) && strpos($content, "\n") === FALSE;
    }
}