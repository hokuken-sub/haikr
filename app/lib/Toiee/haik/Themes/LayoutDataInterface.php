<?php
namespace Toiee\haik\Themes;

interface LayoutDataInterface {

    /**
     * set layout data
     * @params string $key key of data
     */
    public function set($key, $value);

    /**
     * set layout data only once
     * @params string $context context of data if context is already exist then data is not set
     * @params string $key key of data
     */
    public function set_once($context, $key, $value);

    /**
     * get layout data
     * @params string $key key of data
     * @return string data of $key
     */
    public function get($key);

    /**
     * get layout data
     * @return assoc all data
     */
    public function getAll();
    
    /**
     * data exists?
     * @params string $key key of data
     * @return boolean data existance
     */
    public function has($key);

    /**
     * append layout data
     * @params string $key key of data
     * @params string $value append data
     */
    public function append($key, $value);

    /**
     * append layout data only once
     * @params string $context context of data if context is already exist then data is not set
     * @params string $key key of data
     * @params string $value append data
     */
    public function append_once($context, $key, $value);

    /**
     * prepend layout data
     * @params string $key key of data
     * @params string $value append data
     */
    public function prepend($key, $value);

    /**
     * prepend layout data only once
     * @params string $context context of data if context is already exist then data is not set
     * @params string $key key of data
     * @params string $value append data
     */
    public function prepend_once($set_key, $key, $value);
    
    /**
     * Delete data
     * @params string $key key of data
     */
    public function delete($key);
    
}