<?php
namespace Toiee\haik\Plugins\Alert;

use Toiee\haik\Plugins\Plugin;

class AlertPlugin extends Plugin {

    public function convert($params = array(), $body = '')
    {
        if (count($params) === 0)
        {
            return '<div class="alert alert-warning">'.\Parser::parse($body).'</div>';
        }

        $base_class = 'alert';
        $prefix = $base_class.'-';
        $type = 'warning';
        $close = $close_class = '';
        $custom_class = '';

        foreach ($params as $param)
        {
            switch ($param)
            {
                case 'success':
                case 'info'   :
                case 'warning':
                case 'danger' :
                    $type = $param;
                    break;
                case 'close':
                    $close = '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                    $close_class = ' alert-dismissable';
                    break;
                default:
                    $custom_class = ' '.$param;
            }
        }

        return '<div class="'.$base_class.' '.$prefix.$type.$close_class.$custom_class.'">'.$close.\Parser::parse($body).'</div>';
    }
}