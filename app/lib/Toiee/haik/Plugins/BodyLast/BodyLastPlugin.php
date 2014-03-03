<?php
namespace Toiee\haik\Plugins\BodyLast;

use Toiee\haik\Plugins\Plugin;

class BodyLastPlugin extends Plugin {

    /**
     * convert call via HaikMarkdown :::{plugin-name(...):::
     * @params array $params
     * @params string $body when {...} was set
     * @return string converted HTML string
     * @throws RuntimeException when unimplement
     */
	public function convert($params = array(), $body = '')
	{
	    \Theme::append('body_last', $body);
	    return '';
	}

}
