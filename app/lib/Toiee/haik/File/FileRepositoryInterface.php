<?php
namespace Toiee\haik\File;

interface FileRepositoryInterface {

    /**
     * Get list in range
     *
     * @param integer $page
     * @return array of files
     */
    public function listGet($page = 1);

    /**
     * Get list by type in range
     *
     * @param string $type type of file
     * @param integer $page
     * @return array of files
     */
    public function listByType($type, $page = 1);

    /**
     * Get starred file list in range
     *
     * @param integer $page
     * @return array of files
     */
    public function listStarred($page = 1);

    /**
     * Is file exists?
     *
     * @param string $id
     * @return existance
     */
    public function exists($id);

    /**
     * Get file by ID
     * @param string $id
     * @return FileInterface
     */
    public function retrieve($id);
}