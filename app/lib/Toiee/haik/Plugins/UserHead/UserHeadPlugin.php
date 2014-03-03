<?php
namespace Toiee\haik\Plugins\UserHead;

use Toiee\haik\Plugins\Plugin;

class UserHeadPlugin extends Plugin {

    /**
     * convert call via HaikMarkdown :::{plugin-name(...):::
     * @params array $params
     * @params string $body when {...} was set
     * @return string converted HTML string
     * @throws RuntimeException when unimplement
     */
	public function convert($params = array(), $body = '')
	{
		\Theme::append('user_head', $body);
		return "";
	}

}