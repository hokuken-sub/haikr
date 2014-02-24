<?php
namespace Toiee\haik\Themes;

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
            }
        }
        return $parsed_config;
    }

    protected function parseLayouts($layouts)
    {
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
}