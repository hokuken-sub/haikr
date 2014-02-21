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
            if ( ! \Auth::check())
            {
                return '';
            }
            return '<p class="text-danger">You need to put parameter! ( Usage: &icon(search); )</p>';
        }

        $base_class = 'glyphicon';
        $prefix = $base_class.'-';
        $type = '';
        foreach ($params as $param)
        {
            switch ($param)
            {
                case 'glyphicon':
                // haik-icon will be added in the future
                case 'haik-icon':
                // font awesome icon will be added in the future
                case 'fa':
                    $base_class = $param;
                    $prefix = $base_class.'-';
                    break;
                default:
                    $type = $param;

            }
        }
        return '<i class="haik-plugin-icon '.$base_class.' '.$prefix.e($type).'"></i>';

    }
}