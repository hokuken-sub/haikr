<?php
namespace Toiee\haik\Plugins\BodyFirst;

use Toiee\haik\Plugins\Plugin;

class BodyFirstPlugin extends Plugin {

    /**
     * convert call via HaikMarkdown :::{plugin-name(...):::
     * @params array $params
     * @params string $body when {...} was set
     * @return string converted HTML string
     * @throws RuntimeException when unimplement
     */
	public function convert($params = array(), $body = '')
	{
	    \Theme::append('body_first', $body);
	    return '';
	}

}
