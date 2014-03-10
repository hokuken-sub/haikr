<?php
namespace Toiee\haik\Plugins;

class Utility {

    /**
     * parse data (ie. 3, 3+3, 3.customclass) for column
     * @param  string $column column string
     * @return array columun data, when not match then return false
     */
    public static function parseColumnData($column = '')
    {
        if (preg_match('{ ^(\d+)(?:\+(\d+))?((?:\.[a-zA-Z0-9_-]+)+)?$ }mx', $column, $matches))
        {
            $data = array();
            $data['cols']   = !empty($matches[1]) ? (int)$matches[1] : 0;
            $data['offset'] = !empty($matches[2]) ? (int)$matches[2] : 0;
            $data['class']  = !empty($matches[3]) ? trim(str_replace('.', ' ', $matches[3])) : '';
            return $data;
        }
        return false;
    }
    
    /**
     * makes class for column
     * @param  array $columnData column data
     * @return string class for columun
     */
    public static function createColumnClass($columnData)
    {
        $classes = array();
        
        if (is_array($columnData))
        {
            if ( ! isset($columnData['cols']))
            {
                return '';
            }
        
            foreach($columnData as $column => $value)
            {
                $option = '';
                switch($column)
                {
                    case 'offset':
                        $option = "offset-";
                    case 'cols':
                        if ($value > 0)
                        {
                            $classes[] = 'col-sm-'. $option . $value;
                        }
                        break;
                    case 'class':
                        if ($value !== '')
                        {
                            $classes[] = $value;
                        }
                        break;
                }
            }
            
            return join(" ", $classes);
        }
        
        return '';
    }
    
    /**
     * makes wrapped html with column class
     * @param  mixed  $columnData if array then columndata, if string then need parse
     * @param  string or array $columnOption column options
     * @param  string content html
     * @return string wrapped html with column class
     */
    public static function wrapColumn($columnData, $content)
    {
        if ( ! is_array($columnData))
        {
            $columnData = self::parseColumnData($columnData);
        }

        $col_classes = self::createColumnClass($columnData);

        if ($col_classes === '')
        {
            return $content;
        }

        $html = '<div class="row"><div class="'.$col_classes.'">'.$content.'</div></div>';

        return $html;
    }    

}
