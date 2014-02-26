<?php
namespace Toiee\haik\File;

interface FileInterface {

    /**
     * Mark star the file
     *
     * @param boolean $star
     */
    public function star($star = true);

    /**
     * Is the file private?
     *
     * @return boolean is the file private?
     */
    public function isPrivate();
}