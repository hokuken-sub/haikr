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


        // 28: check 'glyphicon' exists in $params
        // 30: check key of 'glyphicon'
        // 31: alias to $icon_type because $params[key] will delete
        // 33: delete 'glyphicon'
        // 35: convert to string
        if (in_array('glyphicon', $params))
        {
          $key = array_search('glyphicon', $params);
          $icon_type = $params[$key];

          unset($params[$key]);

          $icon_value = implode('', $params);
          return '<i class="'.$icon_type.' '.$icon_type.'-'.$icon_value.'">';

        }

        return '';
    }
}