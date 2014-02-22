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

        # check $body has "====".
        if (preg_match("/\n====\n/", $body))
        {
            $body = explode("\n====\n", $body);
            list($title, $content) = $body;

            # check $body after parsed is heading.
            if (preg_match("/(<h[1-6].*?>).*?(<\/h[1-6]>)/", \Parser::parse($title)))
            {
                # start check detail
                switch (true)
                {
                    # if user use markdown, put {.panel-title}
                    case preg_match_all("/^#{1,6}/", $title):
                        $title = $title.' {.panel-title}';
                        break;

                    # if user use raw html without panel-title class, put it.
                    case preg_match("/<h[1-6]>/", $title):
                        $title = preg_replace("/>/", " class=\"panel-title\">", $title, 1);
                        break;
                }
            }

            return '<div class="haik-plugin-panel '.$base_class.' '.$prefix.$type.'">'
                 . '<div class="panel-heading">'.\Parser::parse($title).'</div>'
                 . '<div class="panel-body">'.\Parser::parse($content).'</div></div>';
        }

        return '<div class="haik-plugin-panel '.$base_class.' '.$prefix.$type.'">'
             . '<div class="panel-body">'.\Parser::parse($body).'</div></div>';
    }
}