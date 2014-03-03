<?php
namespace Toiee\haik\Themes;

use View;

class LocalRepository implements ThemeRepositoryInterface {

    protected $manager;

    /**
     * path to theme repository
     */
    protected $path;

    public function __construct(ThemeManager $manager, $path)
    {
        $this->manager = $manager;
        $this->path = $path;
    }

    /**
     * theme $name is exists?
     * @params string $name theme name
     * @return boolean
     */
    public function exists($name)
    {
        $theme_dir = $this->getPath($name);
        $config_path = $this->getConfigFilePath($name);
        if (is_dir($theme_dir) && file_exists($config_path))
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
            return new Theme($this->manager, $this->getConfig($name));
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
     * Get path to Theme's directory
     * @param string $name theme name
     * @return string path to theme dir
     */
    public function getPath($name)
    {
        return str_finish($this->path, '/') . $name;
    }

    public function getConfig($name)
    {
        $config = array();
        $config_path = $this->getConfigFilePath($name);
        if ($this->exists($name))
        {
            $config = json_decode(file_get_contents($config_path), true);
        }
        if (array_key_exists('name', $config))
        {
            $config['name'] = $name;
        }
        return $this->parseConfig($config);
    }

    public function parseConfig($config)
    {
        return $this->manager->configParser->parse($config);
    }

    protected function getConfigFilePath($name)
    {
        return $this->getPath($name) . '/theme.json';
    }
}