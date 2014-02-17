<?php
namespace Toiee\haik\Plugins\Deco;

use Toiee\haik\Plugins\Plugin;

class DecoPlugin extends Plugin {

    /**
     * inline call via HaikMarkdown &plugin-name(...){...};
     * @params array $params
     * @params string $body when {...} was set
     * @return string converted HTML string
     * @throws RuntimeException when unimplement
     */
    function inline($params = array(), $body = '')
    {
        $strong = false;
        $ccnt = 0;
        foreach ($params as $v)
        {
    		if( is_numeric($v) )
    		{
    			$size = $v.'px';
    		}
    		else if (preg_match('/^(\d|\.)/', $v))
    		{
    			$size = $v;
    		}
    		else if (preg_match('/small|medium|large/', $v))
    		{
    			$size = $v;
    		}
    		else if ($v=='bold' || $v=='b' ){
    			$strong = true;
    		}
    		else if ($v=='underline' || $v=='u')
    		{
    			$underline = 'text-decoration:underline;';
    		}
    		else if ($v=='italic' || $v=='i')
    		{
    			$italic = 'font-style:italic;';
    		}
    		else if (preg_match('/^(#[0-9a-f]{3}|#[0-9a-f]{6}|[a-z-]+)$/i', $v))
    		{
    			$color[$ccnt] = $v;
    			$ccnt++;
    		}
    		else if($v==''){
    			$color[$ccnt] = 'inherit';
    			$ccnt++;
    		}
        }
        
        $style = array();        
        if (isset($size)) $style[] = "font-size:{$size};";
        if (isset($color[0]) && $color[0]!='') $style[] = "color:{$color[0]};";
        if (isset($color[1]) && $color[1]!='') $style[] = "background-color:{$color[1]};";
        if (isset($underline)) $style[] = $underline;
        if (isset($italic)) $style[] = $italic;
        $style = join('', $style);
        if ($style != '') $style = ' style="'.$style.'"';
        
        if ($strong)
        {
            $body = '<strong>'.$body.'</strong>';
        }
	
        return '<span class="haik-plugin-deco"'.$style.'>'.$body.'</span>';
    }
}