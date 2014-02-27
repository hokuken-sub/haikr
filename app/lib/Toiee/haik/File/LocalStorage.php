<?php
namespace Toiee\haik\File;

use File;
use Response;

class LocalStorage implements FileStorageInterface {

    /**
     * Get file content data
     *
     * @param FileInterface $file
     * @return string file contents
     * @throws FileNotFoundException
     */
    public function get($file)
    {
        return File::get($this->getPath($file->getName()));
    }

    /**
     * Save file content data
     *
     * @param FileInterface $file
     * @param mixed $content
     * @return boolean when success return true
     */
    public function save($file, $content)
    {
        return File::put($this->getPath($file->getName()), $content);
    }

    /**
     * Delete file
     *
     * @param  FileInterface $file 
     * @return boolean when success return true
     */
    public function delete($file)
    {
        return File::delete($this->getPath($file->getName()));
    }

    /**
     * Copy file
     *
     * @param FileInterface $file path to the source file
     * @param string $dest_id the destination path
     * @return boolean when success return true
     */
    public function copy($file, $dest_id)
    {
        return File::copy($this->getPath($file->getName()), $this->getPath($dest_id));
    }

    /**
     * Is file exists?
     *
     * @param FileInterface $file
     * @return boolean existance
     */
    public function exists($file)
    {
        return File::exists($this->getPath($file->getName()));
    }

    /**
     * Download file
     *
     * @param FileInterface $file
     */
    public function download($file)
    {
        $filename = $file->getName();
        Response::download($this->getPath($filename), $filename, array('content-type' => $file->mime_type));
    }

    /**
     * Pass through file
     *
     * @param string FileInterface $file
     */
    public function passthru($file)
    {
        $filepath = $this->getPath($file->getName());
        $fp = fopen($filepath), 'rb');

        // send header
        header("Content-Type: ". $file->mime_type);
        header("Content-Length: " . filesize($filepath));
        
        // dump data
        fpassthru($fp);
        exit;        
    }

    /**
     * Get file path
     *
     * @param string $id
     * @return string file path
     */
    protected function getPath($id)
    {
        return Config::get('file::local.path').Haik::getID() . '/'. $id;
    }

}