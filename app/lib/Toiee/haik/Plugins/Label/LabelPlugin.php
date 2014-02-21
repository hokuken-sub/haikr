<?php
namespace Toiee\haik\Plugins\Label;

use Toiee\haik\Plugins\Plugin;

class LabelPlugin extends Plugin {

    /**
     * inline call via HaikMarkdown &plugin-name(...);
     * @params array $params
     * @params string $body when {...} was set
     * @return string converted HTML string
     * @throws RuntimeException when unimplement
     */
    function inline($params = array(), $body = '')
    {
        $custom_class = '';
        $label_type = 'default';
        foreach ($params as $param)
        {
            switch($param)
            {
                case 'default':
                case 'primary':
                case 'success':
                case 'info'   :
                case 'warning':
                case 'danger' :
                    $label_type = $param;    
                    break;
                default :
                    $custom_class = $param;
            }
        }
        
        $label_class = "label label-{$label_type}";
        $custom_class = ($custom_class) ? " {$custom_class}" : "";
        
        $html = '<span class="haik-plugin-label '.$label_class.e($custom_class).'">'.$body.'</span>';

        return $html;
    }

}