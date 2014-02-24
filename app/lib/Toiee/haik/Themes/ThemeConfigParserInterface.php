<?php
namespace Toiee\haik\Themes;

interface ThemeConfigParserInterface {

    /**
     * Parse config array
     *
     * @param assoc $config config array load from config file
     * @return assoc $config array
     */
    public function parse($config);
}
