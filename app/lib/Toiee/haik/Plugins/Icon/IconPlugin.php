<?php
namespace Toiee\haik\Plugins\Icon;

use Toiee\haik\Plugins\Plugin;

class IconPlugin extends Plugin {

    /**
     * inline call via HaikMarkdown &plugin-name(...);
     * @params array $params
     * @params string $body when {...} was set
     * @return string converted HTML string
     * @throws RuntimeException when unimplement
     */
    function inline($params = array(), $body = '')
    {
        return '';
    }
}