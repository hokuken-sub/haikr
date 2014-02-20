<?php
namespace Toiee\haik\Providers;

use Illuminate\Support\ServiceProvider;

class HaikServiceProvider extends ServiceProvider {
    
    public function boot()
    {
        \App::singleton('SiteManagerInterface', function()
        {
            return new SiteManager;
        });
    }

    /**
     * register ServiceProvider
     */
    public function register()
    {
        $this->app['haik'] = $this->app->share(function()
        {
            return \App::make('SiteManagerInterface');
        });
    }
}