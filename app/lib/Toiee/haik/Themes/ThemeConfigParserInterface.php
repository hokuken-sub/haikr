<?php
namespace Toiee\haik\Themes;

interface ThemeConfigParserInterface {

    /**
     * Parse config array
     *
     * @param mixed $config config array load from config file
     * @return mixed $config array
     * @throws Toiee\haik\Themes\ThemeInvalidConfigProvidedException when config has not required values
     */
    public function parse($config);
}
