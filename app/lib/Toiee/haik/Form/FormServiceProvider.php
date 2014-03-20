<?php
namespace Toiee\haik\Form;

use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->registerFormRepositoryInterface();
        $this->registerFormManager();
    }

    public function register()
    {
    }

    public function registerFormRepositoryInterface()
    {
        $this->app->bind('FormRepositoryInterface', function()
        {
            return new FormRepository;
        });
    }

    public function registerFormManager()
    {
        $this->app->singleton('FormManager', function($app)
        {
            return new FormManager(
                $app->make('FormRepositoryInterface')
            );
        });
    }
}
