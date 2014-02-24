<?php
namespace Toiee\haik\Plugins\Cols;

use Toiee\haik\Plugins\Plugin;

class ColsPlugin extends Plugin {

    protected $cols;
    protected $colBase;
    
    protected $params;
    protected $body;

    public function __construct()
    {
        $this->colBase = array (
            'cols'   => 12,
            'offset' => 0,
            'class'  => '',
            'style'  => '',
            'body'   => '',
        );

        $this->cols = array();
    }

    public function convert($params = array(), $body = '')
    {
        // set params
        $this->params = $params;
        $this->body = $body;
        
        $this->parseParams();

        $html = '';

        return $html;
    }

    protected function parseParams()
    {
        $cols = array();
        foreach ($this->params as $param)
        {
            
        }
        
        if (count($cols) == 0)
        {
            $this->cols[] = $this->colBase;
        }
    }

    protected function parseBody()
    {
        $this->cols['body'] = $this->body;
    }

}