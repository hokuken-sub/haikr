<?php
namespace Toiee\haik\File;

interface FileInterface {

    /**
     * Save the file as new file
     */
    public function save();

    /**
     * Update the file
     */
    public function update();

    /**
     * Delete the file
     */
    public function delete();

    /**
     * Mark star the file
     */
    public function star();

    /**
     * Is the file private?
     *
     * @return boolean is the file private?
     */
    public function isPrivate();
}