<?php
namespace Toiee\haik\Plugins\Button;

use Toiee\haik\Plugins\Plugin;
use \Page;
use \Validator;


class ButtonPlugin extends Plugin {

    /**
     * inline call via HaikMarkdown &plugin-name(...){...};
     * @params array $params
     * @params string $body when {...} was set
     * @return string converted HTML string
     * @throws RuntimeException when unimplement
     */
    function inline($params = array(), $body = '')
    {
        $href = '#';
        if (count($params) > 0)
        {
            $href = array_shift($params);
            $href = \Link::url($href);
        }

        $type = ' btn-default';
        $size = '';
        $class = '';
        foreach($params as $v)
        {
            switch($v){
                case 'primary':
                case 'info':
                case 'success':
                case 'warning':
                case 'danger':
                case 'link':
                case 'default':
                    $type = ' btn-'.$v;
                    break;
                case 'theme':
                    $type = ' btn-'.$v;
                    break;
                case 'large':
                case 'lg':
                    $size = ' btn-lg';
                    break;
                case 'small':
                case 'sm':
                    $size = ' btn-sm';
                    break;
                case 'mini':
                case 'xs':
                    $size = ' btn-xs';
                    break;
                case 'block':
                    $size = ' btn-'.$v;
                    break;
                default:
                    $class .= ' '.$v;
            }
        }

        $html = '<a class="haik-plugin-button btn'.$type.$size.e($class).'" href="'.e($href).'">'.$body.'</a>';
        return $html;
    }
}