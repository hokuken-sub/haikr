<?php
namespace Toiee\HaikPlugin;

use App;

class PluginManager {

    protected $path;
    protected static $loadableList = array();

    public function __construct()
    {
        $this->path = '';
/*
        $this->path = str_finish(Config::get('app.haik.plugin.folder'), '/');
        if ( ! is_dir($this->path))
        {
            throw new \RuntimeException("Directory doesn't exist: $this->path");
        }
*/
    }

    /**
     * plugin $id is exists?
     * @params string $id plugin id
     * @return boolean
     */
    public function exists($id)
    {
        $plugin_name = studly_case($id);
        if ( ! is_dir($this->path . $plugin_name) OR
             ! file_exists($this->getClassPath($id)))
        {
            return false;
        }
        
        $class_name = self::getClassName($id);

        if (array_key_exists($class_name, self::$loadableList))
        {
            return true;
        }

        include $this->getClassPath($id);
        
        if (class_exists($class_name))
        {
            self::$loadableList[$class_name] = $class_name;
            return true;
        }
        return false;
    }
    
    /**
     * load Plugin by id
     * @params string $id plugin id
     * @return PluginInterface The Plugin
     * @throws InvalidArgumentException when $id was not exist
     */
    public function load($id)
    {
        if ($this->exists($id))
        {
            $class_name = self::getClassName($id);
            return new $class_name;
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
    
    /**
     * get plugin folder path
     * @return string $path
     */
    public function getPath()
    {
        return $this->path;
    }
    
    /**
     * get class file path by plugin id
     * @params string $id plugin id
     * @return string path of plugin class file
     */
    public function getClassPath($id)
    {
        $plugin_name = studly_case($id);
        return $plugin_name . '/' . $plugin_name . 'Plugin.php';
    }
    
    /**
     * get class name by plugin id
     * @params string $id plugin id
     * @return string class name of plugin
     */
    public static function getClassName($id)
    {
        return $class_name = studly_case($id) . 'Plugin';
    }


    /**
    * get a Plugin object
    * @params string $id plugin name
    * @return PluginInterface|NULL plugin obj or null
    * @throws InvalidArgumentException when plugin $id was not exist
    */
    public function get($id)
    {
        
        if ( ! $this->exists($id))
        {
            throw new \InvalidArgumentException("A plugin with id=$id was not exist");
        }
        return $this->load($id);
        
    }

    /**
    * get plugin list
    * @return array of list id
    */
    public function allPlugins()
    {
        return $this->getAll();
    }

}