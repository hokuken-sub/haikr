<?php
namespace Toiee\haik\Themes\ThemeInterface.php

interface ThemeInterface {

    /**
     * Determine if the given configuration value exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function has($key);

    /**
     * Get the specified configuration value.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public function get($key, $default = null);
    
    /**
     * Set layout
     *
     * @param string $layout layout name
     */
    public function layoutSet($layout);
    
    /**
     * Get current layout
     *
     * @return string layout name
     */
    public function layoutGet();

    /**
     * Get array of layouts the theme has.
     *
     * @return array of string layout name
     */
    public function layouts();

    /**
     * Set color
     *
     * @param string $color color name
     */
    public function colorSet($color);

    /**
     * Get current color
     *
     * @return string|false color name when color not set return false
     */
    public function colorGet();

    /**
     * Get array of colors the theme has.
     *
     * @return array of string color name
     */
    public function colors();
    
    /**
     * Get array of textures the theme has.
     *
     * @return array of string texture name
     */
    public function textures();
    
    /**
     * Set texture
     *
     * @param string $texture layout name
     */
    public function textureSet($texture);    

    /**
     * Get current texture
     *
     * @return string texture name when texture not set return false
     */
    public function textureGet();

    /**
     * Make view
     *
     * @return View
     */
    public function make();
    
    /**
     * Take over other theme's layout|color|texture status
     *
     * @param ThemeInterface $theme_taked_over
     * @return void
     */
    protected function takeOver(ThemeInterface $theme_taked_over);
}