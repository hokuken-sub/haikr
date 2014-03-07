<?php
namespace Toiee\haik\Plugins;

class PluginCounter {

    protected static $counts = array();

    public static function inc($plugin_class_name)
    {
        $plugin_name = class_basename($plugin_class_name);
        if (isset(self::$counts[$plugin_name]))
        {
            self::$counts[$plugin_name] += 1;
        }
        else
        {
            self::$counts[$plugin_name] = 1;
        }
    }

    public static function get($plugin_class_name)
    {
        $plugin_name = class_basename($plugin_class_name);
        if (isset(self::$counts[$plugin_name]))
        {
            return self::$counts[$plugin_name];
        }
        else
        {
            return 0;
        }
    }

    public static function all()
    {
        return self::$counts;
    }
}
