<?php
namespace Toiee\haik\Themes;

use App;

class Theme implements ThemeInterface {
    
    protected $theme_data;

    protected $config;

    protected $layout;
    protected $color;
    protected $texture;
    
    public function __construct(ThemeDataInterface $theme_data, ThemeConfigLoaderInterface $loader, ThemeInterface $theme_taked_over = null)
    {
        $this->theme_data = $theme_data;
        $this->loader = $loader;
        $this->config = $this->loader->load($this);
        
        $this->initLayouts();
        $this->initColors();
        $this->initTextures();
        
        if ( ! is_null($theme_taked_over))
        {
            $this->takeOver($theme_taked_over);
        }
        
        $this->createFilter();
    }
    
    /**
     * Set array of layouts parse config
     * layouts: [foo, bar] => {foo: {default}, bar: {default}}
     *
     * @return void
     * @throws ThemeNotHasLayoutsException when layouts options are not set
     */
    protected function initLayouts()
    {
        $layouts = $this->get('layouts', false);
        if ( ! $layouts)
        {
            throw new ThemeNotHasLayoutsException;
        }
        $this->layout = $layouts;
        //TODO: enable simple layouts option
        
        $this->initDefaultLayout();
    }
    
    /**
     * Set default layout name use config[default_layout]
     * if default_layout not set then use first layout name in layouts
     *
     * @return void
     */
    protected function initDefaultLayout()
    {
        $default_layout = $this->get('default_layout', false);
        if ($default_layout === false)
        {
            foreach ($this->get('layouts', array()) as $layout => $data)
            {
                $this->layout = $layout;
                return;
            }
        }
        $this->layout = $default_layout;
    }
    
    protected function initColors()
    {
        //TODO: enable simple colors option
        $this->color = false;
    }
    
    protected function initTextures()
    {
        //TODO: enable textures option
        $this->texture = false;
    }
    
    protected function createFilter()
    {
        foreach (array('layout', 'color', 'texture') as $variation)
        {
            $method = camel_case("{$variation}_create_fiter");
            if (method_exists($this, $method))
            {
                $this->$method();
            }
        }
    }
    
    protected function layoutCreateFilter(){}

    protected function colorCreateFilter(){}

    protected function textureCreateFilter(){}

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
        if (in_array($color, $this->get('colors')))
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
        if (in_array($texture, $this->get('textures')))
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
     * Render view
     *
     * @return View
     */
    public function render()
    {
        foreach (array('layout', 'color', 'texture') as $variation)
        {
            $method = camel_case("{$variation}_after_fiter");
            if (method_exists($this, $method))
            {
                $this->$method();
            }
        }

        //TODO: make view using ThemeData
        return App::make('View');
    }

    protected function layoutAfterFilter(){}

    protected function colorAfterFilter(){}

    protected function textureAfterFilter(){}

    /**
     * Take over other theme's layout|color|texture status
     *
     * @param ThemeInterface $theme_taked_over
     * @return void
     */
    public function takeOver(ThemeInterface $theme_taked_over)
    {
        $this->layoutSet($theme_taked_over->layoutGet());
        $this->colorSet($theme_taked_over->colorGet());
        $this->textureSet($theme_taked_over->textureGet());
    }    
}