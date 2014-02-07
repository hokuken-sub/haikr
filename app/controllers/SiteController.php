<?php 

class SiteController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Set site parameters.
     *
     * @return Response
     */
    public function settings()
    {
        $title = Haik::get('title');
        $description = Haik::get('description');
        
        $this->layout = View::make('settings.layouts.editor')->with(array(
           'title'    => $title,
           'description'    => $description,
           'view' => 'settings.site_settings',
           'nav' => 'settings.includes.nav',
        ));
    }
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        if (Request::isMethod('post'))
        {
            $site_id = 1;
            $site = Site::find($site_id);
            
            if ( ! $site)
            {
                App::abort(404);
            }

            $site->title = Input::get('title');
            $site->description = Input::get('description');
            
            
            if ($site->save())
            {
                
            }
            else
            {
                
            }
            
            return Redirect::to(action('SiteController@settings'));
        }

        return Redirect::to(action('SiteController@settings'));
    }

}