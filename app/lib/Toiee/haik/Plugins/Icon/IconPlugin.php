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

        $icon_type = $prefix = $value = '';
        foreach($params as $param)
        {
            if($param == 'glyphicon')
            {
                $icon_type = $param.' ';
                $prefix = $param.'-';
            } else
            {
                $value = $param;
            }
        }
        return '<i class="'.$icon_type.$prefix.$value.'"></i>';

    }
}