<?php
namespace Toiee\haik\File;

interface FileInterface {

    /**
     * get identifier
     *
     * @return string file identifier
     */
    public function getIdentifier();

    /**
     * set identifier
     *
     * @param FileInterface for method chain
     */
    public function setIdentifier($identifier);

    /**
     * get file name
     *
     * @return string file name
     */
    public function getName();

    /**
     * Mark star the file
     *
     * @param FileInterface for method chain
     */
    public function star($star = true);

    /**
     * Is the file private?
     *
     * @return boolean is the file private?
     */
    public function isPrivate();
}