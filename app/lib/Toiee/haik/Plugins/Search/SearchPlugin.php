<?php
namespace Toiee\haik\Plugins\Search;

use Toiee\haik\Plugins\Plugin;

class SearchPlugin extends Plugin {

    /**
     * action by http GET or POST /haik--search/...
     * @return NULL or View object
     * @throws RuntimeException when unimplement
     */
    public function action()
    {
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
    }

}
