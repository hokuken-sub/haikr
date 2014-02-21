<?php
namespace Toiee\haik\Themes;

class Theme implements ThemeInterface {
    
    protected $config;
    
    public function __construct(ThemeConfigLoaderInterface $loader, ThemeInterface $theme_taked_over = null)
    {
        $this->loader = $loader;
        $this->config = $this->loader->load($this);
        
        if ( ! is_null($theme_taked_over))
        {
            $this->takeOver($theme_taked_over);
        }
        
        $this->createFilter();
    }
    
    protected function createFilter()
    {
        foreach (array('layout', 'color', 'texture') as $variation)
        {
            $method = camel_case("{$variation}_create_fiter");
            if (metod_exists($this, $method))
            {
                $this->$method();
            }
        }
    }
    
    /**
     * Determine if the given configuration value exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->config);
    }

    /**
     * Get the specified configuration value.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if ($this->has($key))
        {
            return $this->config[$key];
        }
        return $default;
    }

    /**
     * Set layout
     *
     * @param string $layout layout name
     */
    public function layoutSet($layout)
    {
        if (in_array($layout, $this->layouts()))
        {
            $this->layout = $layout;
        }
    }
    
    /**
     * Get current layout
     *
     * @return string layout name
     */
    public function layoutGet()
    {
        return $this->layout;
    }
    
    /**
     * Get array of layouts the theme has.
     *
     * @return array of string layout name
     */
    public function layouts()
    {
        return $this->get('layouts', array());
    }
    
    /**
     * Set color
     *
     * @param string $color color name
     */
    public function colorSet($color)
    {
        if (in_array($color, $this->colors()))
        {
            $this->color = $color;
        }
    }

    /**
     * Get current color
     *
     * @return string|false color name when color not set return false
     */
    public function colorGet()
    {
        return $this->color;
    }
    
    /**
     * Get array of colors the theme has.
     *
     * @return array of string color name
     */
    public function colors()
    {
        return $this->get('colors', array());
    }
    
    /**
     * Get array of textures the theme has.
     *
     * @return array of string texture name
     */
    public function textures()
    {
        return $this->get('textures', array());
    }

    /**
     * Set texture
     *
     * @param string|false $texture layout name
     */
    public function textureSet($texture)
    {
        if (in_array($texture, $this->textures))
        {
            $this->texture = $texture;
        }
    }
    

    /**
     * Get current texture
     *
     * @return string texture name when texture not set return false
     */
    public function textureGet()
    {
        return $this->texture;
    }
    
    /**
     * Make view
     *
     * @return View
     */
    public function make()
    {
        return App::meke('View');
    }

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
     * Take over other theme's layout|color|texture status
     *
     * @param ThemeInterface $theme_taked_over
     * @return void
     */
    protected function takeOver(ThemeInterface $theme_taked_over)
    {
        $this->layoutSet($theme_taked_over->layoutGet());
        $this->colorSet($theme_taked_over->colorGet());
        $this->textureSet($theme_taked_over->textureGet());
    }    
}