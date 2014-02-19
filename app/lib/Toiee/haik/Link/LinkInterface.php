<?php
namespace Toiee\haik\Link;

interface LinkInterface {

    /**
     * return url
     * @params string $link page name or url or ...
     * @return string converted url
     */
    public function url($link);

}