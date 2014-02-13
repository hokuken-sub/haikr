<?php
namespace Toiee\haik\Repositories;

use Config;

class PluginRepository implements PluginRepositoryInterface {

    public function __construct()
    {
    }

    /**
     * plugin $id is exists?
     * @params string $id plugin id
     * @return boolean
     */
    public function exists($id)
    {
        $class_name = self::getClassName($id);
        if (class_exists($class_name, true))
        {
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
     * get class name by plugin id
     * @params string $id plugin id
     * @return string class name of plugin
     */
    public static function getClassName($id)
    {
        $class_name = studly_case($id);
        return $class_name = 'Toiee\haik\Plugins\\'. $class_name.'\\' .$class_name . 'Plugin';
    }
    
}