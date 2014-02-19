<?php
namespace Toiee\haik\Providers;

use App;

class SiteManager {
    
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
     * get page url
     * @params string page name
     * @return string page url
     */
    public function url($pagename = '')
    {
        $url = \Config::get('app.url');
        
        // defaultPageの削除
        $pagename = preg_replace('/^'.\Config::get('app.haik.defaultPage').'/', '', $pagename);
        
        // defaultPageの場合は、URLを返す
        if ($pagename === '') return $url;
        
        // Hashタグがある場合
        $hash = '';
        if (strpos($pagename, '#') !== FALSE)
        {
            list($pagename, $hash) = explode('#', $pagename, 2);
            $hash = '#' . rawurlencode($hash);
        }

        return $url . '/' . rawurlencode($pagename) . $hash;
    }

    /**
     * check page exists
     * @params string page name
     * @return boolean
     */
    public function pageExists($pagename)
    {
        if (strpos($pagename, '#') !== FALSE)
        {
            list($pagename, $tmp) = explode('#', $pagename, 2);
        }

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