<?php
namespace Toiee\haik\Providers;

use App;

class SiteManager implements SiteManagerInterface{
    
    protected $id;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->id = 1;
    }
    
    /**
     * get site ID
     * @return integer site id
     */
    public function getID()
    {
        return $this->id;
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
        $filename = ($pagename === \Config::get('app.haik.defaultPage')) ? '' : (rawurlencode($pagename).'.html');

        return str_finish($url, '/') . $filename;
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
     * check page name
     * @params string page name
     * @return boolean
     */
    public function validatePageName($pagename)
    {
        // check is url
        $validation = \Validator::make(array('url_check'=> $pagename), array('url_check'=>'url'));
        if ( ! $validation->fails())
        {
            return false;
        }
        
        // check page name length
        if (strlen($pagename) > \Config::get('app.haik.pageNameMaxLength'))
        {
            return false;
        }
        
        $pattern = '/\A(?!\s):?[^\r\n\t\f\[\]\/<>#&":]+:?(?<!\s)\z/';
        return !! (preg_match($pattern, $pagename));
    }

    /**
     * get site path (i.e. haik--admin/site/xxx)
     * @return string site path
     */
    public function path()
    {
       
    }
    
    /**
     * search word from pages, files and froms
     * @param  string $word search words
     * @param  string $targets search target (all, page, file, form)
     * @return array results
     */
    public function search($word, $targets = 'all')
    {
        $public = 'all';
        if (! \Auth::check())
        {
            $targets = array('page');
            $public = 'public';
        }
        else if ($targets == 'all')
        {
            $targets = array('page', 'file', 'form');
        }
        else
        {
            $targets = explode(',', $targets);
        }
        
        $results = array();
        foreach ($targets as $target)
        {
            $results[$target] = array();
            switch(trim($target))
            {
                case 'page':
                    $results[$target]['label'] = 'ページ';
                    $results[$target]['rows'] = \Page::site($this->getID())->publicity($public)->search($word)->paginate(15)->getItems();
                    break;
                case 'file':
                    // ! notyet
                    $results[$target]['label'] = 'ファイル';
                    $results[$target]['rows'] = array();
                    break;
                case 'form':
                    // ! notyet
                    $results[$target]['label'] = 'フォーム';
                    $results[$target]['rows'] = array();
                    break;
            }
        }

        return $results;
    }

}