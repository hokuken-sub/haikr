<?php
namespace Toiee\haik\Themes;

interface ThemeChangerInterface {

    /**
     * set theme if theme is exist
     * @params string $theme theme name
     */
    public function themeSet($theme);

    /**
     * get theme name
     * @return string|false theme. if theme is not set then return false
     */
    public function themeGet();

    /**
     * set layout if layout is exist
     * @params string $layout layout name
     */
    public function layoutSet($layout);

    /**
     * get layout name
     * @return string|false layout. if layout is not set then return false
     */
    public function layoutGet();

    /**
     * set color if color is exist
     * @params string $color
     */
    public function colorSet($color);

    /**
     * get color
     * @return string|false color. if color is not set then return false
     */
    public function colorGet();

    /**
     * set texture if texture is exist
     * @params string $texture
     */
    public function textureSet($texture);

    /**
     * get texture
     * @return string|false texture. if texture is not set then return false
     */
    public function textureGet();

}