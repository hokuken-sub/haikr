<?php
namespace Toiee\haik\File;

use Illuminate\Support\ServiceProvider;

class FileServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->app->bind('LocalStorage', function()
        {
            return new LocalStorage;
        });
        $this->app->singleton('FileManager', function($app)
        {
            return new FileManager;
        });
    }

    public function register()
    {
    }
}