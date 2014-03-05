<?php
namespace Toiee\haik\File;

class MimeTypeResolver {

    const DEFAULT_TYPE = 'application/octet-stream';

    /**
     * Get File Type By Content
     *
     * @param $content file content data
     * @return string mime-type of the file
     */
    public function getTypeByContent($content)
    {
        if (strlen($content) === 0) return self::DEFAULT_TYPE;

        if (extension_loaded('finfo'))
        {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
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
            if (file_exists($location))
            {
                return mime_content_type($location);
            }
            else
            {
                return self::DEFAULT_TYPE;
            }
        }
        
    }

}