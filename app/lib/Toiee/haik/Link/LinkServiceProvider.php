<?php
namespace Toiee\haik\Link;

use Illuminate\Support\ServiceProvider;

class LinkServiceProvider extends ServiceProvider {
    
    /**
     * register ServiceProvider
     */
    public function register()
    {
        $this->app['link'] = $this->app->share(function(){
            return new Link(
                array(
                    new PageResolver(\App::make('SiteManagerInterface'))
                )
            );
        });
    }

}
