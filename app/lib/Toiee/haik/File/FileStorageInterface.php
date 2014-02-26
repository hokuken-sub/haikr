<?php
namespace Toiee\haik\File;

interface FileStorageInterface {

    /**
     * Get file content data by ID
     *
     * @param string $id
     * @return FileInterface
     * @throws FileNotFoundException
     */
    public function getData($id);

    /**
     * Save file content data
     *
     * @param mixed $content
     * @return boolean when success return true
     */
    public function saveFile($content);

    /**
     * Update file content by ID
     *
     * @param string $id
     * @param mixed $content
     * @return FileInterface|false when failed return false
     */
    public function update($id, $content);

    /**
     * Delete file by ID
     *
     * @param string $id
     * @return boolean when success return true
     */
    public function delete($id);

    /**
     * Copy file by ID
     *
     * @param string $id
     * @return FileInterface|false when failed return false
     */
    public function copy($id);

    /**
     * Is file exists?
     *
     * @param string $id
     * @return boolean existance
     */
    public function exists($id);

    /**
     * Download file by ID
     *
     * @param string $id
     */
    public function download($id);

    /**
     * Pass through file by ID
     *
     * @param string $id
     */
    public function passthru($id);
}