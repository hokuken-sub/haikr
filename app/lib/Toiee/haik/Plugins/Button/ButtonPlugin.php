<?php
namespace Toiee\haik\Plugins\Button;

use Toiee\haik\Plugins\Plugin;
use \Page;
use \Validator;


class ButtonPlugin extends Plugin {

    /**
     * inline call via HaikMarkdown &plugin-name(...){...};
     * @params array $params
     * @params string $body when {...} was set
     * @return string converted HTML string
     * @throws RuntimeException when unimplement
     */
    function inline($params = array(), $body = '')
    {
        if (count($params) == 0)
        {
            // TODO: エラー処理
            return '';
        }

		$href = array_shift($params);
		
		$validation = Validator::make(array('url_check'=> $href), array('url_check'=>'url'));
		
		$page = Page::where('name', $href)->first();
        if ($page)
        {
			$href = url(rawurlencode($href));
        }
        else if ($validation->fails())
        {
            // URL以外で存在しないページ名の場合
			$href = url('haik-admin/edit/'.rawurlencode($href));
        }

		$type = ' btn-default';
		$size = '';
		$class = '';
		foreach($params as $v)
		{
			switch($v){
				case 'primary':
				case 'info':
				case 'success':
				case 'warning':
				case 'danger':
				case 'link':
				case 'default':
					$type = ' btn-'.$v;
					break;
				case 'theme':
					$type = ' btn-'.$v;
					break;
				case 'large':
				case 'lg':
					$size = ' btn-lg';
					break;
				case 'small':
				case 'sm':
					$size = ' btn-sm';
					break;
				case 'mini':
				case 'xs':
					$size = ' btn-xs';
					break;
				case 'block':
					$size = ' btn-'.$v;
					break;
				default:
					$class .= ' '.$v;
			}
		}

        // !TODO naviに設置した場合の処理
        $wrapper = '%s';
        

        $html = sprintf($wrapper, '<a class="haik-plugin-button btn'.$type.$size.$class.'" href="'.e($href).'">'.$body.'</a>');
        return $html;

    }
}