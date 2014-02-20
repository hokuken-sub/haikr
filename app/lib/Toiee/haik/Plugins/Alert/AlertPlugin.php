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
        $prefix = $type = '';

        return '<div class="'.$base_class.$prefix.$type.'">'.\Parser::parse($body).'</div>';
    }
}