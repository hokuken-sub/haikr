<?php
namespace Toiee\haik\Plugins;

class Utility {

    public static function parseColumnData($columndata = '')
    {
        if (preg_match('{ ^(\d+)(?:\+(\d+))?((?:\.[a-zA-Z0-9_-]+)+)?$ }mx', $columndata, $matches))
        {
            $data = array();
            $data['cols']   = !empty($matches[1]) ? (int)$matches[0] : 0;
            $data['offset'] = !empty($matches[2]) ? (int)$matches[1] : 0;
            $data['class']  = !empty($matches[3]) ? trim(str_replace('.', ' ', $matches[3])) : '';
            return $data;
        }
        return false;
    }
}