<?php
namespace Toiee\haik\Plugins\Search;

use Toiee\haik\Plugins\Plugin;
use Toiee\haik\Plugins\Utility;

class SearchPlugin extends Plugin {
    
    protected $formdata;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

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
            // get post data
            $word = \Input::get('word');
            $this->formdata['word'] = $word;

            $data = \Haik::search($word);
            $html = $this->render($data);
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
                        $this->formdata['class'] = Utility::createColumnClass($col);
                    }
            }
        }

        return self::renderView('template', $this->formdata);
    }

    /**
     * get html (form and results)
     * @params array $results
     * @return string converted HTML string
     */
    protected function render($results)
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
                    'title'      => $row->getTitle(),
                    'sub_title'  => $row->getSubTitle(),
                    'url'        => $row->getUrl(),
                    'caption'    => $row->getCaption(),
                    'thumbnail'  => $row->getThumbnail(),
                    'updated'    => $row->getUpdatedAt()->diffForHumans(),
                );
            }
        }

        $data = array_merge($this->formdata, array('data' => $data));
        return self::renderView('template', $data);
    }

}
