<?php
namespace Toiee\haik\Entities;

interface SearchItemInterface {
    
    /**
     * get title
     * @return string title
     */
    public function getTitle();

    /**
     * get sub title
     * @return string sub title
     */
    public function getSubTitle();

    /**
     * get url
     * @return string url
     */
    public function getUrl();

    /**
     * get caption
     * @return string caption
     */
    public function getCaption();

    /**
     * get thumbnail
     * @return string thumbnail
     */
    public function getThumbnail();

    /**
     * get update date
     * @return string update date
     */
    public function getUpdatedAt();

}
