<?php
namespace Toiee\haik\Plugins;

interface PluginInterface {
    
    /**
     * action by http GET or POST /haik--admin/plugin-name/...
     * @return NULL or View object
     * @throws RuntimeException when unimplement
     */
    public function action();
    
    /**
     * convert text to inline element
     * @params array $params
     * @params string $body when {...} was set
     * @return string converted HTML string
     * @throws RuntimeException when unimplement
     */
    public function inline($params = array(), $body = '');
    
    /**
     * convert text to block element
     * @params array $params
     * @params string $body when :::\n...\n::: was set
     * @return string converted HTML string
     * @throws RuntimeException when unimplement
     */
    public function convert($params = array(), $body = '');
    
}