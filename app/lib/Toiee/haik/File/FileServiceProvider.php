<?php
namespace Toiee\haik\File;

use Illuminate\Support\ServiceProvider;

class FileServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->registerLocalStorage();
        $this->registerFileRepositoryInterface();
        $this->registerFileManager();
    }

    public function register()
    {
    }

    public function registerLocalStorage()
    {
        $this->app->bind('LocalStorage', function()
        {
            return new LocalStorage;
        });
    }

    public function registerFileRepositoryInterface()
    {
        $this->app->bind('FileRepositoryInterface', function()
        {
            return new FileRepository;
        });
    }

    public function registerFileManager()
    {
        $this->app->singleton('FileManager', function($app)
        {
            return new FileManager(
                $app->make('FileRepositoryInterface')
            );
        });
    }
}