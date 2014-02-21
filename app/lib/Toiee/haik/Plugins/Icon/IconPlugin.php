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
        if (count($params) === 0)
        {
            // !TODO: threw error when no params
            return 'error';
        }

        $base_class = $prefix = $type = '';
        foreach ($params as $param)
        {
            if ($param == 'glyphicon')
            {
                $base_class = $param.' ';
                $prefix = $param.'-';
            }
            else
            {
                $type = $param;
            }
        }
        return '<i class="'.$base_class.$prefix.$type.'"></i>';

    }
}