<?php
namespace Toiee\haik\File;

trait ConvertTable {

    protected $extToMimeType = array(
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
        'aiff'  => 'audio/aiff',
        'aiff'  => 'audio/x-aiff',
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

    protected $mimeTypeToHaikFileType = array(
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


}
