<?php
namespace Toiee\haik\Themes;

class LocalRepository implements ThemeRepositoryInterface {

    protected $manager;

    /**
     * path to theme repository
     */
    protected $path;

    public function __construct(ThemeManager $manager, $path)
    {
        $this->path = $path;
    }

    /**
     * theme $name is exists?
     * @params string $name theme name
     * @return boolean
     */
    public function exists($name)
    {
        $theme_class = $this->getClassName($name);
        if (class_exists($theme_class, true))
        {
            return true;
        }
        
        return false;
    }

    /**
     * get Theme interface by theme name
     * @params string $name theme name
     * @return ThemeInterface
     * @throws InvalidArgumentException when $name was not exist
     */
    public function get($name)
    {
        if ($this->exists($name))
        {
            $theme_class = $this->getClassName($name);
            App::bind($theme_class, $theme_class);
            return App::make($theme_class);
        }
        
        throw new \InvalidArgumentException("This {$name} theme was not exist");
    }

    /**
     * get all plugin list
     * @return array of plugin id
     */
    public function getAll()
    {
        return array();
    }
    
    /**
     * get theme class name
     * @return string theme class name
     */
    protected function getClassName($name)
    {
        return studly_case($name.'_theme');
    }

    public function getPath($name)
    {
        return str_finish($this->path, '/') . $name;
    }

    public function getConfig($name)
    {
        //TODO: parse
        return include($this->getPath($name) . '/config.php');
    }
}