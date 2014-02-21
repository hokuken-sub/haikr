<?php
namespace Toiee\haik\Themes;

class ThemeManager implements ThemeDataInterface, ThemeChangerInterface {

    protected $layout_data;
    protected $layout_data_context;
    protected $theme;
    protected $layout;
    protected $color;
    protected $texture;

    public function __construct()
    {
        $this->layout_data = array();
        $this->layout_data_context = array();
    }

    /**
     * set layout data
     * @params string $key key of data
     */
    public function set($key, $value)
    {
        $this->layout_data[$key] = $value;
    }

    /**
     * set layout data only once
     * @params string $context context of data if context is already exist then data is not set
     * @params string $key key of data
     */
    public function setOnce($context, $key, $value)
    {
        if ($this->contextExists($context)) return;
        
        $this->setContext($context);
        $this->layout_data[$key] = $value;
    }

    /**
     * set data of array
     * @param assoc $data
     */
    public function setAll($data)
    {
        if (is_array($data)) $this->layout_data += $data;
    }

    /**
     * get layout data
     * @params string $key key of data
     * @return string|false data of $key. if key is not set then return false
     */
    public function get($key)
    {
        return $this->has($key) ? $this->layout_data[$key] : false;
    }

    /**
     * get layout data
     * @return assoc all data
     */
    public function getAll()
    {
        return $this->layout_data;
    }
    
    /**
     * data exists?
     * @params string $key key of data
     * @return boolean data existance
     */
    public function has($key)
    {
        return array_key_exists($key, $this->layout_data);
    }
    
    protected function contextExists($context)
    {
        return array_key_exists($context, $this->layout_data_context);
    }
    protected function setContext($context)
    {
        $this->layout_data_context[$context] = true;
    }

    /**
     * append layout data
     * @params string $key key of data
     * @params string $value append data
     */
    public function append($key, $value)
    {
        $current_value = $this->has($key) ? $this->get($key) : '';
        $this->set($key, $current_value . $value);
    }

    /**
     * append layout data only once
     * @params string $context context of data if context is already exist then data is not set
     * @params string $key key of data
     * @params string $value append data
     */
    public function appendOnce($context, $key, $value)
    {
        if ($this->contextExists($context)) return;
        $this->setContext($context);
        $this->append($key, $value);
    }

    /**
     * prepend layout data
     * @params string $key key of data
     * @params string $value append data
     */
    public function prepend($key, $value)
    {
        $current_value = $this->has($key) ? $this->get($key) : '';
        $this->set($key, $value . $current_value);
    }

    /**
     * prepend layout data only once
     * @params string $context context of data if context is already exist then data is not set
     * @params string $key key of data
     * @params string $value append data
     */
    public function prependOnce($context, $key, $value)
    {
        if ($this->contextExists($context)) return;
        $this->setContext($context);
        $this->prepend($key, $value);
    }
    
    /**
     * Delete data
     * @params string $key key of data
     */
    public function delete($key)
    {
        if ($this->has($key)) unset($this->layout_data[$key]);
    }
    
    /**
     * set theme if theme is exist
     * @params string $theme theme name
     */
    public function themeSet($theme)
    {
        $this->theme = $theme;
    }

    /**
     * get theme name
     * @return string|false theme. if theme is not set then return false
     */
    public function themeGet()
    {
        if ($this->theme)
        {
            return $this->theme;
        }
        
        return false;
    }

    /**
     * set layout if layout is exist
     * @params string $layout layout name
     */
    public function layoutSet($layout)
    {
        $this->layout = $layout;
    }

    /**
     * get layout name
     * @return string|false layout. if layout is not set then return false
     */
    public function layoutGet()
    {
        if ($this->layout)
        {
            return $this->layout;
        }
        
        return false;
    }

    /**
     * set color if color is exist
     * @params string $color
     */
    public function colorSet($color)
    {
        $this->color = $color;
    }

    /**
     * get color
     * @return string|false color. if color is not set then return false
     */
    public function colorGet()
    {
        if ($this->color)
        {
            return $this->color;
        }
        
        return false;
    }

    /**
     * set texture if texture is exist
     * @params string $texture
     */
    public function textureSet($texture)
    {
        $this->texture = $texture;
    }

    /**
     * get texture
     * @return string|false texture. if texture is not set then return false
     */
    public function textureGet()
    {
        if ($this->texture)
        {
            return $this->texture;
        }
        
        return false;
    }
    

}