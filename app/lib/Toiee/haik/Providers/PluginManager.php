<?php
namespace Toiee\haik\Providers;

use App;

class PluginManager {
    
    public function imATeapot()
    {
        return "I'm a teapot.";
    }
    
    /**
     * get a Plugin object
     * @params string $id plugin name
     * @return PluginInterface|NULL plugin obj or null
     * @throws InvalidArgumentException when plugin $id was not exist
     */
    public function get($id)
    {
        $repository = App::make('PluginRepositoryInterface');
        if ( ! $repository->exists($id))
        {
            throw new \InvalidArgumentException("A plugin with id=$id was not exist");
        }
        return $repository->load($id);
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
    
}