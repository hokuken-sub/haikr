<?php

use Toiee\haik\File\FileInterface;

class SiteFile extends Eloquent implements FileInterface {

    protected $table = 'haik_files';

    /**
     * get identifier
     *
     * @return string file identifier
     */
    public function getIdentifier()
    {
        return $this->key;
    }

    /**
     * set identifier
     *
     * @param FileInterface for method chain
     */
    public function setIdentifier($identifier)
    {
        $this->key = $identifier;
        return $this;
    }

    /**
     * get file name
     *
     * @return string file name
     */
    public function getName()
    {
        if ($this->ext)
        {
            return $this->key.'.'.$this->ext;
        }
        return $this->key;
    }

    /**
     * Mark star the file
     *
     * @param FileInterface for method chain
     */
    public function star($star = true)
    {
        $this->starred = !! $star;
        return $this;
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

    /**
     * Get file storage
     * @return string storage engine name of the file
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * Get existance of the file
     *
     * @return boolean existance
     */
    public function exists()
    {
        return $this->exists;
    }
}
