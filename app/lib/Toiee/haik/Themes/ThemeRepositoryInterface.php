<?php
namespace Toiee\haik\Themes;

interface ThemeRepositoryInterface {

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

}