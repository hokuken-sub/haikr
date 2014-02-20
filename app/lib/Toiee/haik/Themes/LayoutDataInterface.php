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
    public function setOnce($context, $key, $value);

    /**
     * set data of array
     * @param assoc $data
     */
    public function setAll($data);

    /**
     * get layout data
     * @params string $key key of data
     * @return string|false data of $key. if key is not set then return false
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
    public function appendOnce($context, $key, $value);

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
    public function prependOnce($context, $key, $value);
    
    /**
     * Delete data
     * @params string $key key of data
     */
    public function delete($key);
    
}