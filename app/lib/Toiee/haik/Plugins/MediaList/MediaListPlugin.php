<?php
namespace Toiee\haik\Plugins\MediaList;

use Toiee\haik\Plugins\Plugin;

class MediaListPlugin extends Plugin {

    /**
     * convert call via HaikMarkdown :::{#plugin-name}\n...\n:::;
     * @params array $params
     * @params string $body when \n...\n was set
     * @return string converted HTML string
     * @throws RuntimeException when unimplement
     */
    public function convert($params = array(), $body = '')
    {
        
    }
}