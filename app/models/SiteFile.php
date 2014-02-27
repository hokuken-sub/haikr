<?php

use Toiee\haik\File\FileInterface;

class SiteFile extends Eloquent implements FileInterface {

    protected $table = 'haik_files';

    /**
     * get file name
     *
     * @return string file name
     */
    public function getName()
    {
        return $this->key.'.'.$this->ext;   
    }

    /**
     * Mark star the file
     *
     * @param boolean $star
     */
    public function star($star = true)
    {
        $this->starred = !! $star;
        $this->save();
    }

    /**
     * Is the file private?
     *
     * @return boolean is the file private?
     */
    public function isPrivate()
    {
        return ! $this->publicity;
    }

}