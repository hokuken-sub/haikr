<?php
namespace Toiee\haik\File;

interface FileInterface {

    /**
     * get file name
     *
     * @return string file name
     */
    public function getName();

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