<?php
namespace Toiee\haik\Themes;

interface ThemeConfigLoaderInterface {
    
    /**
     * Load config
     * @return assoc config array
     */
    public function load();
}