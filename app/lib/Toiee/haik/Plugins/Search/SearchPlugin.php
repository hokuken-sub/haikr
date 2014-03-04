<?php
namespace Toiee\haik\Plugins\Search;

use Toiee\haik\Plugins\Plugin;
use Toiee\haik\Plugins\Utility;

class SearchPlugin extends Plugin {

    /**
     * action by http GET or POST /haik--search/...
     * @return NULL or View object
     * @throws RuntimeException when unimplement
     */
    public function action()
    {
    }
    
    /**
     * convert call via HaikMarkdown :::{plugin-name(...):::
     * @params array $params
     * @params string $body when {...} was set
     * @return string converted HTML string
     * @throws RuntimeException when unimplement
     */
    public function convert($params = array(), $body = '')
    {
        $data = array(
            'class'       => '',
            'button'      => false,
            'button_type' => 'default',
            'word'        => '',
        );

        foreach ($params as $param)
        {
            switch ($param)
            {
                case 'default':
                case 'primary':
                case 'success':
                case 'info':
                case 'warning':
                case 'danger':
                    $data['button'] = true;
                    $data['button_type'] = $param;
                    break;
                case 'btn':
                case 'button':
                    $data['button'] = true;
                    break;
                default:
                    $col = Utility::parseColumnData($param);
                    if ($col)
                    {
                        $data['class'] = $this->getColumnClass($col);
                    }
            }
        }
        
        return self::renderView('template', $data);
    }

    protected function getColumnClass($col)
    {
        if ( ! $col)
        {
            return false;
        }

        $classes = array();
        if ($col['cols'] > 0)
        {
            $classes[] = 'col-sm-' . $col['cols'];
        }
        if ($col['offset'] > 0)
        {
            $classes[] = 'col-sm-offset-' . $col['offset'];
        }
        if ($col['class'] !== '')
        {
            $classes[] = $col['class'];
        }

        return join(" ", $classes);
    }

}
