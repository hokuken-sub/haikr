<?php
namespace Toiee\haik\Plugins\Cols;

use Toiee\haik\Plugins\Plugin;

class ColsPlugin extends Plugin {

    const COL_MAX_NUM  = 12;
    const COL_DELIMITER = "\n====\n";

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
            'cols'   => self::COL_MAX_NUM,
            'offset' => 0,
            'class'  => '',
            'style'  => '',
            'body'   => '',
        );

        $this->cols = array();
        $this->totalColNum = 0;
        $this->className = '';
        $this->delimiter = self::COL_DELIMITER;
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

        
        $this->parseParams();
        $this->parseBody();
        
        $html = $this->getHtml();
        
        // When over max col, show alert message if auth.
        $alert = '';
        if ($this->totalColNum > self::COL_MAX_NUM)
        {
            if (\Auth::check())
            {
                $message = 'There are over '. self::COL_MAX_NUM . ' columns.';
                $alert = with(\Plugin::get('alert'))->convert(array('danger', 'close'), $message);
                $html = $alert . "\n" . $html;
            }
        }

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
                    $this->delimiter = "\n" . trim($param) . "\n";
                }
                continue;
            }
            
            $cols = array_merge($this->colBase, $cols);
            $this->cols[] = $cols;
            $this->totalColNum += $cols['cols'];
        }
    }

    /**
     * parse body
     */
    protected function parseBody()
    {
        if (count($this->cols) === 0)
        {
            // if parameter is not set then make cols with body
        	$data = explode($this->delimiter, $this->body);
    		$col_num = (int)(self::COL_MAX_NUM / count($data));
    		for ($i = 0; $i < count($data); $i++)
    		{
    		    $col['cols'] = $col_num;
                $this->cols[$i] = array_merge($this->colBase, $col);
    		}
        }
        
        // if parameter and body delimiter is not match then bind body over cols 
        $data = array_pad(explode($this->delimiter, $this->body, count($this->cols)), count($this->cols), '');
    	for($i = 0; $i < count($this->cols); $i++)
    	{
    		if (isset($data[$i]))
    		{
    		    if (preg_match('/(?:^|\n)STYLE:(.+?)\n/', $data[$i], $mts))
    		    {
    		        $this->cols[$i]['style'] = trim($mts[1]);
        		    $data[$i] = preg_replace('/'.preg_quote($mts[0], '/'). '/', '', $data[$i], 1);
    		    }

    		    if (preg_match('/(?:^|\n)CLASS:(.+?)\n/', $data[$i], $mts))
    		    {
    		        $this->cols[$i]['class'] = trim($this->cols[$i]['class'] . ' ' . trim($mts[1]));
        		    $data[$i] = preg_replace('/'.preg_quote($mts[0], '/'). '/', '', $data[$i], 1);
    		    }

    		    $this->cols[$i]['body'] = $data[$i];
    		}
    	}
    }
    
    protected function getHtml()
    {
        $col_body = array();
        $col_format = '<div class="%s" style="%s">%s</div>';

        foreach ($this->cols as $col)
        {
            $span   = 'col-sm-'.$col['cols'];
            $offset = $col['offset'] ? (' col-sm-offset-' . $col['offset']) : '';
            $class  = $col['class']  ? (' ' . $col['class']) : '';
            $style  = $col['style']  ? $col['style'] : '';
            $body = \Parser::parse($col['body']);

            $col_body[] = sprintf($col_format, ($span . $offset . $class), $style, $body);
        }
        
        $top_class = $this->className ? (' ' . $this->className) : '';
        
        $html = '<div class="haik-plugin-cols row'.$top_class.'">'."\n".join("\n", $col_body)."\n".'</div>';

        return $html;
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