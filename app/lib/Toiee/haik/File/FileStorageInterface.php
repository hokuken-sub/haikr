<?php
namespace Toiee\haik\File;

interface FileStorageInterface {

    /**
     * Get file content data
     *
     * @param FileInterface $file
     * @return string file contents
     * @throws FileNotFoundException
     */
    public function get($file);

    /**
     * Save file content data
     *
     * @param FileInterface $file
     * @param mixed $content
     * @return integer file size when faile then return false
     */
    public function save($file, $content);

    /**
     * Delete file
     *
     * @param  FileInterface $file 
     * @return boolean when success return true
     */
    public function delete($file);

    /**
     * Copy file
     *
     * @param FileInterface $file path to the source file
     * @param string $dest_id the destination path
     * @return boolean when success return true
     */
    public function copy($file, $dest_id);

    /**
     * Is file exists?
     *
     * @param FileInterface $file
     * @return boolean existance
     */
    public function exists($file);

    /**
     * Download file
     *
     * @param FileInterface $file
     */
    public function download($file);

    /**
     * Pass through file
     *
     * @param string FileInterface $file
     */
    public function passthru($file);
}