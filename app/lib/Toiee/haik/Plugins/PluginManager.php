<?php
namespace Toiee\haik\Plugins;

use App;

class PluginManager {
    
    /**
     * get a Plugin object
     * @params string $id plugin name
     * @return PluginInterface|NULL plugin obj or null
     * @throws InvalidArgumentException when plugin $id was not exist
     */
    public function get($id)
    {
        $class_name = class_basename(self::getClassName($id));
        if (App::bound($class_name))
        {
            return App::make($class_name);
        }
        
        $repository = App::make('PluginRepositoryInterface');
        
        if ( ! $repository->exists($id))
        {
            throw new \InvalidArgumentException("A plugin with id=$id was not exist");
        }
        
        $plugin = $repository->load($id);
        App::instance($class_name, $plugin);
        return App::make($class_name);
    }
    
    /**
     * get plugin list
     * @return array of list id
     */
    public function allPlugins()
    {
        $repository = App::make('PluginRepositoryInterface');
        return $repository->getAll();
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