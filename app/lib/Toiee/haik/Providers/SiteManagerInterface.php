<?php
namespace Toiee\haik\Providers;

interface SiteManagerInterface {

    /**
     * get site config value by name
     * @params string $name site config name
     * @return mixed config value
     * @throws InvalidArgumentException when site config name was not exist
     */
    public function get($name);

    /**
     * save site config value
     * @params string $name site config name
     * @params mixed $value site config value
     * @return boolean true when success
     * @throws InvalidArgumentException when site config name was not exist
     */
    public function save($name, $value);

    /**
     * get public page list
     * @params boolean $all when set true return all pages
     * @return array page list (page_name, page_title)
     */
    public function pages($all = false);

    /**
     * get recent updated page id list
     * @params boolean $all when set true return all pages
     * @params integer $limit number of pages
     * @return array sorted page list by updated_at (page id)
     */
    public function recentPages($all = false, $limit = null);

    /**
     * get page url
     * @params string page name
     * @return string page url
     */
    public function url($pagename = '');

    /**
     * check page exists
     * @params string page name
     * @return boolean
     */
    public function pageExists($pagename);

    /**
     * get site path (i.e. haik-admin/site/xxx)
     * @return string site path
     */
    public function path();

}