<?php
namespace Toiee\haik\Plugins;

abstract class Plugin implements PluginInterface {
    
    /**
     * action by http GET or POST /haik--plugin-name/
     * @return NULL or View object
     * @throws RuntimeException when unimplement
     */
    public function action()
    {
        throw new \RuntimeException('not implemented');
    }
    
    /**
     * convert text to inline element
     * @params array $params
     * @params string $body when {...} was set
     * @return string converted HTML string
     * @throws RuntimeException when unimplement
     */
    public function inline($params = array(), $body = '')
    {
        throw new \RuntimeException('not implemented');
    }
    
    /**
     * convert text to block element
     * @params array $params
     * @params string $body when :::\n...\n::: was set
     * @return string converted HTML string
     * @throws RuntimeException when unimplement
     */
    public function convert($params = array(), $body = '')
    {
        throw new \RuntimeException('not implemented');
    }

    /**
     * render view file
     * @params string $view [namespace::]viewfile
     * @params array $data
     * @return string converted HTML string
     */
    public static function renderView($view, $data)
    {
        $namespace = class_basename(get_called_class());

        if (strpos($view, '::') !== false)
        {
            list($namespace, $view) = explode("::", $view, 2);
        }

        $viewfile = $namespace . "::" . $view;
        if ( ! \View::exists($viewfile))
        {
            $dirname = dirname(with(new \ReflectionClass(get_called_class()))->getFileName());
            \View::addLocation($dirname.'/views');
            \View::addNamespace($namespace, $dirname.'/views');
        }

        return \View::make($viewfile, $data)->render();
    }
}