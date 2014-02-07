<?php
namespace Toiee\haik\Providers;

use Illuminate\Support\ServiceProvider;

class HaikServiceProvider extends ServiceProvider {
    
    /**
     * register ServiceProvider
     */
    public function register()
    {
        $this->app['haik'] = $this->app->share(function()
        {
            return new SiteManager();
        });
    }
}