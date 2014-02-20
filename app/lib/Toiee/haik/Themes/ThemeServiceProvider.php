<?php
namespace Toiee\haik\Themes;

use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->app->singleton('ThemeManager', function()
        {
            return new ThemeManager();
        });
    }

    public function register()
    {
        $this->app['theme'] = $this->app->share(function()
        {
            return \App::make('ThemeManager');
        });
    }
}