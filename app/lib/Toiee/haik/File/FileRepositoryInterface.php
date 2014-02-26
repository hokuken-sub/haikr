<?php
namespace Toiee\haik\File;

interface FileRepositoryInterface {

    /**
     * Get list in range
     *
     * @param mixed $range
     * @return array of files
     */
    public function list($range);

    /**
     * Get list by type in range
     *
     * @param mixed $range
     * @return array of files
     */
    public function listByType($range);

    /**
     * Get starred file list in range
     *
     * @param mixed $range
     * @return array of files
     */
    public function listStarred($range);

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