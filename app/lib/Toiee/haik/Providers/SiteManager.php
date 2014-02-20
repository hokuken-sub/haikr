<?php
namespace Toiee\haik\Providers;

use App;

class SiteManager implements SiteManagerInterface{
    
    protected $id;
    
    public function __construct()
    {
        $this->id = 1;
    }
    
    /**
     * get site config value by name
     * @params string $name site config name
     * @return mixed config value
     * @throws InvalidArgumentException when site config name was not exist
     */
    public function get($name)
    {
        $site = \Site::find($this->id);

        if (isset($site->$name))
        {
            return $site->$name;
        }

        throw new \InvalidArgumentException("A plugin with was not exist");
    }

    /**
     * save site config value
     * @params string $name site config name
     * @params mixed $value site config value
     * @return boolean true when success
     * @throws InvalidArgumentException when site config name was not exist
     */
    public function save($name, $value)
    {
        $site = \Site::find($this->id);

        if (isset($site->$name))
        {
            $site->$name = $value;
            
            return $site->save();
        }

        throw new \InvalidArgumentException("A plugin with was not exist");
    }

    /**
     * get public page list
     * @params boolean $all when set true return all pages
     * @return array page list (page_name, page_title)
     */
    public function pages($all = false)
    {
        $page = array();
        
        if ($all)
        {
            $page = \Page::lists('title', 'name');
        }
        else
        {
            $page = \Page::where('title', '!=', '')->lists('title', 'name');
        }
    
       return $page;
    }

    /**
     * get recent updated page id list
     * @params boolean $all when set true return all pages
     * @params integer $limit number of pages
     * @return array sorted page list by updated_at (page id)
     */
    public function recentPages($all = false, $limit = null)
    {
       
    }

    /**
     * get site base url with trailing slash
     * @return string site url with trailing slash
     */
    public function url()
    {
        return str_finish(\Config::get('app.url'), '/');
    }

    /**
     * get page url
     * @params string page name
     * @return string page url
     */
    public function pageUrl($pagename)
    {
        $url = $this->url();
        $pagename = ($pagename === \Config::get('app.haik.defaultPage')) ? '' : rawurlencode($pagename);

        return str_finish($url, '/') . $pagename;
    }

    /**
     * check page exists
     * @params string page name
     * @return boolean
     */
    public function pageExists($pagename)
    {
        return !! \Page::where('name', $pagename)->first();
    }

    /**
     * get site path (i.e. haik-admin/site/xxx)
     * @return string site path
     */
    public function path()
    {
       
    }

}