<?php
namespace Toiee\haik\Plugins\MediaList;

use Toiee\haik\Plugins\Plugin;
use Toiee\haik\Plugins\Slide\SlidePlugin;
use Toiee\haik\Plugins\Utility;

class MediaListPlugin extends SlidePlugin {

    const DEFAULT_IMAGE = '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">';

    protected function initialize()
    {
        $this->view = 'medialist';
        $this->options = array(
            'wrapperOpen'   => '',
            'wrapperClose'  => '',
        );
    }

    protected function adjustImage($html)
    {
        return str_replace(
                          '<img', '<img class="media-object"',
                          strip_tags($html, '<img>')
                          );
    }

    protected function adjustHeading($html)
    {
        if ( ! preg_match('{ <h[1-6][^>]*?class=".*?" }mx', $html))
        {
            return preg_replace('{ <h([1-6])(.*?>) }mx', '<h\1 class="media-heading"\2', $html);
        }
        else
        {
            return $html;
        }
    }

    /**
     * Adjust item data
     *
     * @param mixed $itemData data of item
     * @return mixed adjusted item data
     */
    protected function adjustData($itemData)
    {
        extract($itemData['body_data']);

        if ( ! isset($elements[$max_line])) return $itemData;

        $html = \Parser::parse($elements[$max_line]);
        if ( ! $imageSet && preg_match('{ <img\b.*?> }mx', $html))
        {
            $itemData['image'] = str_replace(
                                      '<img', '<img class="media-object"',
                                      strip_tags($html, '<img>')
                                      );
            $itemData['align'] = 'pull-right';

            unset($itemData['body_data']['elements'][$max_line]);
        }
        return $itemData;
    }

    protected function checkParams()
    {
        foreach ($this->params as $i => $param)
        {
            $data = Utility::parseColumnData($param);
            if ($data)
            {
                $col_classes = $this->createColumnClass($data);
                $this->options['wrapperOpen'] = '<div class="row"><div class="'.$col_classes.'">';
                $this->options['wrapperClose'] = '</div></div>';
            }
        }
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