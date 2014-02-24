<?php
namespace Toiee\haik\Plugins\Cols;

use Toiee\haik\Plugins\Plugin;

class ColsPlugin extends Plugin {

    const MAX_COL_NUM  = 12;

    protected $className;
    protected $delimiter;

    protected $cols;
    protected $colBase;
    
    protected $params;
    protected $body;
    
    protected $totalColNum;

    public function __construct()
    {
        $this->colBase = array (
            'cols'   => self::MAX_COL_NUM,
            'offset' => 0,
            'class'  => '',
            'style'  => '',
            'body'   => '',
        );

        $this->cols = array();
        $this->totalColNum = 0;
        $this->className = '';
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
        // set params
        $this->params = $params;
        $this->body = $body;
        
        $message = '';
        
        $this->parseParams();
        
        // !TODO over max col num
        if ($this->totalColNum > self::MAX_COL_NUM)
        {
            $message = 'Over '. self::MAX_COL_NUM . 'columns.';
        }

        $html = '';

        return $html;
    }

    /**
     * parse params
     */
    protected function parseParams()
    {

        foreach ($this->params as $param)
        {
            $cols = $this->parseParam($param);
            if (count($cols) === 0)
            {
                if (preg_match('/^class=(.+)$/', $param, $mts))
                {
                    // if you want add class to top div
                    $this->className = trim($mts[1]);
                }
                else
                {
                    // if you want change delimiter
                    $this->delimiter = "\r" . trim($param) . "\r";
                }
            }
            
            $this->cols[] = array_merge($this->colBase, $cols);
            $this->totalColNum++;
        }

        if (count($this->params) == 0)
        {
            $this->cols[] = $this->colBase;
            $this->totalColNum = 1;
        }
    }

    /**
     * parse body
     */
    protected function parseBody()
    {
        $this->cols['body'] = $this->body;
    }
    
    /**
     * parse cols param
     * @return array parameter for cols
     */
    protected function parseParam($param)
    {
        $data = array();
        if (preg_match('/^(\d+)(?:\+(\d+))?((?:\.[a-zA-Z0-9_-]+)+)?$/', $param, $mts))
        {
            $data['cols']   = (int)$mts[1];
            $data['offset'] = isset($mts[2]) ? (int)$mts[2] : 0;
            $data['class']  = isset($mts[3]) ? trim(str_replace('.', ' ',$mts[3])) : '';
        }

        return $data;
    }

}