<?php
namespace Toiee\haik\Plugins\Panel;

use Toiee\haik\Plugins\Plugin;

class PanelPlugin extends Plugin {
  
    /**
     * convert call via HaikMarkdown {#plugin-name}
     * @params array $params
     * @params string $body when :::\n...\n::: was set
     * @return string converted HTML string
     * @throws RuntimeException when unimplement
     */
    public function convert($params = array(), $body = '')
    {
        $base_class = 'panel';
        $prefix = $base_class.'-';
        $type = 'default';

        foreach ($params as $param)
        {
            switch ($param)
            {
                case 'default':
                case 'primary':
                case 'success':
                case 'info':
                case 'warning':
                case 'danger':
                    $type = $param;
                    break;
            }
        }

        if (preg_match("/\n====\n/", $body))
        {
            $body = explode("\n====\n", $body);
            list($title, $content) = $body;

            return '<div class="haik-plugin-panel '.$base_class.' '.$prefix.$type.'">'
                 . '<div class="panel-heading">'.\Parser::parse($title).'</div>'
                 . '<div class="panel-body">'.\Parser::parse($content).'</div></div>';
        }

        return '<div class="haik-plugin-panel '.$base_class.' '.$prefix.$type.'">'
             . '<div class="panel-body">'.\Parser::parse($body).'</div></div>';
    }
}