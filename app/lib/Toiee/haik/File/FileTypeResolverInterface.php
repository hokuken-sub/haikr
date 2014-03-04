<?php
namespace Toiee\haik\File;

interface FileTypeResolverInterface {

    /**
     * Get File Type By Content
     *
     * @param $content file content data
     * @return string mime-type of the file
     */
    public function getTypeByContent($content);

    /**
     * Get File Type By URL or path
     *
     * @param $location file URL or path
     * @return string mime-type of the file
     */
    public function getTypeByLocation($location);

}