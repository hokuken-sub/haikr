<?php
namespace Toiee\haik\File;

class MimeTypeResolver {

    const DEFAULT_TYPE = 'application/octet-stream';
    
    protected $mimeTypeConvertTable = array(
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'jp2'   => 'image/jp2',
        'png'   => 'image/png',
        'gif'   => 'image/gif',
        'bmp'   => 'image/bmp',
        'ai'    => 'application/postscript',
        'txt'   => 'text/plain',
        'csv'   => 'text/csv',
        'tsv'   => 'text/tab-separated-values',
        'doc'   => 'application/msword',
        'xls'   => 'application/vnd.ms-excel',
        'ppt'   => 'application/vnd.ms-powerpoint',
        'pdf'   => 'application/pdf',
        'xdw'   => 'application/vnd.fujixerox.docuworks',
        'htm'   => 'text/html',
        'html'  => 'text/html',
        'css'   => 'text/css',
        'js'    => 'text/javascript',
        'hdml'  => 'text/x-hdml',
        'mp3'   => 'audio/mpeg',
        'mp4'   => 'audio/mp4',
        'wav'   => 'audio/x-wav',
        'mid'   => 'audio/midi',
        'midi'  => 'audio/midi',
        'mmf'   => 'application/x-smaf',
        'mpg'   => 'video/mpeg',
        'mpeg'  => 'video/mpeg',
        'wmv'   => 'video/x-ms-wmv',
        'swf'   => 'application/x-shockwave-flash',
        '3g2'   => 'video/3gpp2',
        'zip'   => 'application/zip',
        'lha'   => 'application/x-lzh',
        'lzh'   => 'application/x-lzh',
        'tar'   => 'application/x-tar',
        'tgz'   => 'application/x-tar',
    );

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
            if (file_exists($location) OR preg_match('{\A(:?https?|ftp)://}', $location))
            {
                $info = pathinfo($location);
                if (isset($info['extension']) && isset($this->mimeTypeConvertTable[$info['extension']]))
                {
                    return $this->mimeTypeConvertTable[$info['extension']];
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
                return self::DEFAULT_TYPE;
            }
        }
    }

}