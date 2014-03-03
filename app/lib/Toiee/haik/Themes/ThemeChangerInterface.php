<?php
namespace Toiee\haik\Themes;

interface ThemeChangerInterface {

    /**
     * set theme if theme is exist
     * @params string|ThemeInterface $theme theme name or Theme object
     */
    public function themeSet($theme);

    /**
     * get theme name
     * @return ThemeInterface|false theme. if theme is not set then return false
     */
    public function themeGet();
}