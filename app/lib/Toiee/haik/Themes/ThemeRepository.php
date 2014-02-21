<?php
namespace Toiee\haik\Themes;

class ThemeRepository implements ThemeRepositoryInterface {

    public function __construct()
    {
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
            $theme_class = stutly_case($name.'_theme');
            App::bind($theme_class, $theme_class);
            return App::make($theme_class);
        }
        
        throw new \InvalidArgumentException("A plugin with id=$id was not exist");
    }
    

    /**
     * get all plugin list
     * @return array of plugin id
     */
    public function getAll()
    {
        return array();
    }
}