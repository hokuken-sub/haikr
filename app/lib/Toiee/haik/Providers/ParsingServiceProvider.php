<?php
namespace Toiee\haik\Providers;

use Illuminate\Support\ServiceProvider;

class ParsingServiceProvider extends ServiceProvider {
    
    public function boot()
    {
        \App::singleton('ParserInterface', function()
        {
            return new \Toiee\haik\Entities\HaikMarkdown();
        });
    }
    
    /**
     * register ServiceProvider
     */
    public function register()
    {
        $this->app['parser'] = $this->app->share(function()
        {
            return \App::make('ParserInterface');
        });
    }
}