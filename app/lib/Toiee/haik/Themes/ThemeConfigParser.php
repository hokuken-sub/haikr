<?php
namespace Toiee\haik\Themes;
use Config;

class ThemeConfigParser implements ThemeConfigParserInterface {

    /**
     * Parse config array short hands to full stack options array
     *
     * @param mixed $config config array load from config file
     * @return mixed $config array
     * @throws Toiee\haik\Themes\ThemeInvalidConfigProvidedException when config has not required values
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
                case 'defaultLayout':
                case 'styleFile':
                case 'version':
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

        $parsed_config = $this->setDefaultLayout($parsed_config);

        if ( ! $this->validate($parsed_config))
        {
            throw new ThemeInvalidConfigProvidedException("Invalid theme config provided");
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
        foreach ($colors as $key => $color)
        {
            if (is_int($key))
            {
                $name = '';
                if (is_string($color))
                {
                    $name = trim($color);
                    $data = array();
                }
                else if (is_array($color) && isset($color['name']))
                {
                    $name = trim($color['name']);
                    unset($color['name']);
                    $data = $color;
                }

                if ($name !== '')
                {
                    $data = array_merge(
                        array(
                            'className'  => "haik-theme-color-{$name}",
                        ),
                        (array)$data
                    );
                    $colors[$name] = $data;
                }
                unset($colors[$key]);
            }
            else
            {
                $colors[$key] = array_merge(
                    array(
                        'className'  => '',
                    ),
                    (array)$color
                );
            }
        }
        return $colors;
    }

    protected function parseTextures($textures)
    {
        foreach ($textures as $key => $texture)
        {
            if (is_int($key))
            {
                $name = '';
                if (is_string($texture))
                {
                    $name = trim($texture);
                    $data = array();
                }
                else if (is_array($texture) && isset($texture['name']))
                {
                    $name = trim($texture['name']);
                    unset($texture['name']);
                    $data = $texture;
                }

                if ($name !== '')
                {
                    $data = array_merge(
                        array(
                            'className'  => "haik-theme-texture-{$name}",
                        ),
                        (array)$data
                    );
                    $textures[$name] = $data;
                }
                unset($textures[$key]);
            }
            else
            {
                $textures[$key] = array_merge(
                    array(
                        'className'  => '',
                    ),
                    (array)$texture
                );
            }
        }
        return $textures;
    }
    
    protected function getDefaultPartials()
    {
        return Config::get('theme.partials.default', array());
    }

    protected function setDefaultLayout($config)
    {
        $defaultLayout = isset($config['defaultLayout']) ? $config['defaultLayout'] : '';
        if ($defaultLayout !== '' && isset($config['layouts'][$defaultLayout]))
        {
            return $config;
        }

        foreach ($config['layouts'] as $layout_name => $layout_data)
        {
            $config['defaultLayout'] = $layout_name;
            return $config;
        }
        return $config;
    }

    /**
     * validate config array
     *
     * @param mixed $config
     * @return boolean is valid
     */
    protected function validate($config)
    {
        $has_error = true;

        if (
            isset($config['name']) && $config['name'] !== ''
         && isset($config['version']) && $config['version'] !== ''
         && isset($config['layouts']) && ! empty($config['layouts'])
        )
        {
            $has_error = false;
        }

        return ! $has_error;
    }
}