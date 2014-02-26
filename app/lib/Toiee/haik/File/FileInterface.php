<?php
namespace Toiee\haik\File;

interface FileInterface {

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