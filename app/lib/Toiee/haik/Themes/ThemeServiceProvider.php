<?php
namespace Toiee\haik\Themes;

use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->app->singleton('ThemeConfigParserInterface', function()
        {
            return new ThemeConfigParser;
        });
        $this->app->singleton('ThemeManager', function($app)
        {
            return new ThemeManager(
                $app->make('ThemeConfigParserInterface')
            );
        });
        $this->setThemeRepository();
    }

    public function register()
    {
        $this->app['theme'] = $this->app->share(function()
        {
            return \App::make('ThemeManager');
        });
    }
    
    protected function setThemeRepository()
    {
        $this->app['ThemeManager']->setRepositoryDriver($this->app['config']['theme.repository']);
    }
}