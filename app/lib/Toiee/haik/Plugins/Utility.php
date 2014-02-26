<?php
namespace Toiee\haik\Plugins;

class Utility {

    public static function parseColumnData($columndata = '')
    {
        if (preg_match('{ ^(\d+)(?:(\+\d+))?(?:(\.[a-zA-Z0-9_-]+)+)?$ }mx', $columndata, $matches))
        {
            $data = array();
            return $data;
        }
        return false;
    }
}