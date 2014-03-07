<?php
namespace Toiee\haik\Plugins\Search;

use Toiee\haik\Plugins\Plugin;
use Toiee\haik\Plugins\Utility;

class SearchPlugin extends Plugin {
    
    protected $formdata;
    
    public function __construct()
    {
        $this->formdata = array(
            'class'       => 'col-sm-12',
            'button'      => false,
            'button_type' => 'default',
            'word'        => '',
        );
    }
    

    /**
     * action by http GET or POST /haik--search/...
     * @return NULL or View object
     * @throws RuntimeException when unimplement
     */
    public function action()
    {
        $html = '';

        if (\Request::isMethod('get'))
        {
            // ! 1 get post data
            $word = \Input::get('word');
            $this->formdata['word'] = $word;

            // ! 2 search
            $data = \Haik::search($word);

            // ! 3 display
            $html = $this->getHtml($data);
        }
        
        return $html;

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
                    $this->formdata['button'] = true;
                    $this->formdata['button_type'] = $param;
                    break;
                case 'btn':
                case 'button':
                    $this->formdata['button'] = true;
                    break;
                default:
                    $col = Utility::parseColumnData($param);
                    if ($col)
                    {
                        $this->formdata['class'] = $this->getColumnClass($col);
                    }
            }
        }

        return self::renderView('template', $this->formdata);
    }

    protected function getHtml($results)
    {
        $data = array(); 
        foreach ($results as $key => $target)
        {
            $data[$key] = array();
            $data[$key]['label'] = $target['label'];
            $data[$key]['rows'] = array();
            
            foreach ($target['rows'] as $row)
            {
                $data[$key]['rows'][] = array(
                    'title'     => $row->getTitle(),
                    'sub_title' => $row->getSubTitle(),
                    'url'       => $row->getUrl(),
                    'caption'   => $row->getCaption(),
                    'thumbnail' => $row->getThumbnail(),
                );
            }
        }

        $data = array_merge($this->formdata, array('data' => $data));
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
