<?php
namespace Toiee\haik\Themes;

class ThemeManager implements ThemeDataInterface, ThemeChangerInterface {

    protected $layout_data;
    protected $layout_data_context;

    /** ThemeRepositoryInterface */
    protected $themes;

    /** Theme object */
    protected $theme;

    public function __construct()
    {
        $this->layout_data = array();
        $this->layout_data_context = array();

        $this->themes = null;
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
     * @params string|ThemeInterface $theme theme name or Theme object
     */
    public function themeSet($theme)
    {
        if ($theme instanceof ThemeInterface)
        {
            $this->theme = $theme;
        }
        else if (is_string($theme))
        {
            // !TODO: create Theme object
        }
    }

    /**
     * get theme name
     * @return ThemeInterface|false theme. if theme is not set then return false
     */
    public function themeGet()
    {
        if ($this->theme)
        {
            return $this->theme;
        }
        return false;
    }
    
    public function setRepositoryDriver($repository)
    {
		$method = 'create'.ucfirst($repository).'RepositoryDriver';

		if (method_exists($this, $method))
		{
			$this->themes = $this->$method();
			return;
		}

		throw new \InvalidArgumentException("Repository Driver [$repository] not supported.");
    }
    
    protected function createLocalRepositoryDriver()
    {
        $path = \Config::get('theme.local.path');
        return new LocalRepository($path);
    }
}