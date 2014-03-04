<?php
namespace Toiee\haik\Plugins\Panel;

use Toiee\haik\Plugins\Plugin;
use Toiee\haik\Plugins\Utility;

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
        $wrapper_open = $wrapper_close = '';

        if (count($params) > 0)
        {
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
                    default:
                        $data = Utility::parseColumnData($param);
                        if ($data)
                        {
                            $col_classes = $this->createColumnClass($data);
                            $wrapper_open = '<div class="row"><div class="'.$col_classes.'">';
                            $wrapper_close = '</div></div>';
                        }
                }
            }
        }

        # check $body has "====".
        if (preg_match('{ \n+====\n+ }mx', $body))
        {
            $body = preg_split('{ \n+====\n+ }mx', $body, 2);
            list($title, $content) = $body;
            $parse_title = \Parser::parse($title);

            # check $parse_title after parsed is heading.
            if (preg_match_all('{ (<h([1-6]).*?>)(.*?(</h\2>)) }mx', $parse_title, $matches))
            {
                # prepare replacing heading.
                $serches = $matches[0];
                $replaces = array();
                # check heading has class.
                foreach ($matches[1] as $i => $heading)
                {
                    if ( ! preg_match('{ \sclass[ ]*?=[ ]*".*?" }mx', $heading))
                    {
                        # add panel-title class to heading.
                        $heading = str_replace('>', ' class="panel-title">', $heading);
                    }
                    $replaces[] = $heading.$matches[3][$i];
                }
                # replace $parse_title with right class.
                if (count($replaces) > 0)
                $parse_title = str_replace($serches, $replaces, $parse_title);
            }

            $html = '<div class="haik-plugin-panel '.$base_class.' '.$prefix.$type.'">'
                  . '<div class="panel-heading">'.$parse_title.'</div>'
                  . '<div class="panel-body">'.\Parser::parse($content).'</div></div>';

            return $wrapper_open . $html . $wrapper_close;
        }

        $html = '<div class="haik-plugin-panel '.$base_class.' '.$prefix.$type.'">'
              . '<div class="panel-body">'.\Parser::parse($body).'</div></div>';

        return $wrapper_open . $html . $wrapper_close;
    }

    protected function createColumnClass($data)
    {
        $classes = array();
        if ($data['cols'] > 0)
        {
            $classes[] = 'col-sm-' . $data['cols'];
        }
        if ($data['offset'] > 0)
        {
            $classes[] = 'col-sm-offset-' . $data['offset'];
        }
        if ($data['class'] !== '')
        {
            $classes[] = $data['class'];
        }
        return join(" ", $classes);
    }
}