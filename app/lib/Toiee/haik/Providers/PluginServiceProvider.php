<?php
namespace Toiee\haik\Providers;

use Illuminate\Support\ServiceProvider;

class PluginServiceProvider extends ServiceProvider {
    
    /**
     * register ServiceProvider
     */
    public function register()
    {
        $this->app['plugin'] = $this->app->share(function()
        {
            return new PluginManager();
        });
        $this->app->bind('PluginRepositoryInterface', function()
        {
            return new \Toiee\haik\Repositories\PluginRepository;
        });
    }
}