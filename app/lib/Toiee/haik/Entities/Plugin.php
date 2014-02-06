<?php
namespace Toiee\haik\Entities;

abstract class Plugin implements PluginInterface {
    
    /**
     * action by http GET or POST /haik-admin/plugin-name/...
     * @return NULL or View object
     * @throws RuntimeException when unimplement
     */
    public function action()
    {
        throw new RuntimeException('not implemented');
    }
    
    /**
     * inline call via HaikMarkdown &plugin-name(...){...};
     * @params array $params
     * @params string $body when {...} was set
     * @return string converted HTML string
     * @throws RuntimeException when unimplement
     */
    public function inline($params = array(), $body = '')
    {
        throw new RuntimeException('not implemented');
    }
    
    /**
     * convert call via HaikMarkdown {#plugin-name} or ::: {#plugin-name}\n...\n:::
     * @params array $params
     * @params string $body when :::\n...\n::: was set
     * @return string converted HTML string
     * @throws RuntimeException when unimplement
     */
    public function convert($params = array(), $body = '')
    {
        throw new RuntimeException('not implemented');
    }
    
}