<?php
namespace Toiee\haik\Themes;
use Config;

class ThemeConfigParser implements ThemeConfigParserInterface {

    /**
     * Parse config array short hands to full stack options array
     *
     * @param assoc $config config array load from config file
     * @return assoc $config array
     */
    public function parse($config)
    {
        $parsed_config = array();

        foreach ($config as $key => $value)
        {
            switch ($key)
            {
                // sigle line string
                case 'name':
                case 'default_layout':
                case 'style_file':
                case 'version':
                case 'sample_style_file':
                case 'thumbnail':
                    $parsed_config[$key] = trim($value);
                    break;
                
                // allow short hands
                case 'layouts':
                case 'colors':
                case 'textures':
                    $method_name = 'parse' . ucfirst($key);
                    if (method_exists($this, $method_name))
                    {
                        $parsed_config[$key] = $this->$method_name($value);
                    }
                    break;
                // other options
                default:
                    $parsed_config[$key] = $value;
            }
        }
        return $parsed_config;
    }

    /**
     * Parse layouts array
     * Acceptable array is like ["foo", "bar", "buzz"] or {foo : {filename: "...", partial: "...", thumbnail: "..."}}
     */
    protected function parseLayouts($layouts)
    {
        foreach ($layouts as $key => $layout)
        {
            if (is_int($key))
            {
                $name = '';
                if (is_string($layout))
                {
                    $name = trim($layout);
                    $data = array();
                }
                else if (is_array($layout) && isset($layout['name']))
                {
                    $name = trim($layout['name']);
                    unset($layout['name']);
                    $data = $layout;
                }
                
                if ($name !== '')
                {
                    $data = array_merge_recursive(
                        array(
                            'filename'  => "{$name}.layout.blade.php",
                            'partials'  => $this->getDefaultPartials(),
                            'thumbnail' => "assets/images/{$name}.thumbnail.png",
                        ),
                        (array)$data
                    );
                    $layouts[$name] = $data;
                }
                unset($layouts[$key]);
            }
            else
            {
                $layouts[$key] = array_merge(
                    array(
                        'filename'  => '',
                        'partials'  => $this->getDefaultPartials(),
                        'thumbnail' => '',
                    ),
                    (array)$layout
                );
            }
        }
        return $layouts;
    }

    protected function parseColors($colors)
    {
        return $colors;
    }

    protected function parseTextures($textures)
    {
        return $textures;
    }
    
    protected function getDefaultPartials()
    {
        return Config::get('theme.partials.default', array());
    }
}