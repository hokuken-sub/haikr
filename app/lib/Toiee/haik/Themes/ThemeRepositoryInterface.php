<?php
namespace Toiee\haik\Themes;

interface ThemeRepositoryInterface {

    /**
     * theme $name is exists?
     * @params string $name theme name
     * @return boolean
     */
    public function exists($name);

    /**
     * get Theme interface by theme name
     * @params string $name theme name
     * @return ThemeInterface
     * @throws InvalidArgumentException when $name was not exist
     */
    public function get($name);
    
    /**
     * get all theme list
     * @return array of theme name
     */
    public function getAll();

    /**
     * get Theme's config array
     * @param string $name theme name
     * @return assoc config array
     * @throws InvalidArgumentException when $name was not exist
     */
    public function getConfig($name);

}