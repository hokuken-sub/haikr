<?php
namespace Toiee\haik\Plugins\MediaList;

use Toiee\haik\Plugins\Plugin;
use Toiee\haik\Plugins\Utility;

class MediaListPlugin extends Plugin {

    const DEFAULT_MEDIA_OBJECT = '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">';

    protected $align;
    protected $image;
    protected $imageSet;
    protected $heading;
    protected $headingSet;
    protected $content;
    protected $mediaList = array();

    public function setUp()
    {
        $this->align = 'pull-left';
        $this->image = self::DEFAULT_MEDIA_OBJECT;
        $this->heading = $this->content = $this->html = '';

        $this->imageSet = false;
        $this->headingSet = false;
    }

    /**
     * convert call via HaikMarkdown :::{#plugin-name}\n...\n:::;
     * @params array $params
     * @params string $body when \n...\n was set
     * @return string converted HTML string
     * @throws RuntimeException when unimplement
     */
    public function convert($params = array(), $body = '')
    {
        $medialists = explode("\n====\n", $body);

        foreach ($medialists as $i => $medialist)
        {
            $this->mediaList[] = $this->createMediaList($medialist);
        }
        $html = join("\n", $this->mediaList);

        if (count($params) > 0)
        {
            $data = Utility::parseColumnData($params[0]);
            $col_classes = $data ? $this->createColumnClass($data) : '';
            $wrapper_open = '<div class="row"><div class="'.$col_classes.'">';
            $wrapper_close = '</div></div>';
            $html = $wrapper_open . $html . $wrapper_close;
        }
        return $html;
    }

    protected function createMediaList($md)
    {
        $this->setUp();

        $elements = preg_split('{ \n+ }mx', trim($medialist));
        $line_count = count($elements);
        $max_line = $line_count - 1;
        
        // 最初の2行のみ
        for ($line = 0; $line < 2 && $line < $line_count; $line++)
        {
            $html = \Parser::parse($elements[$line]);

            //画像をセット
            if ( ! $this->imageSet && preg_match('{ <img\b.*?> }mx', $html))
            {
                $this->image = str_replace(
                                          '<img', '<img class="media-object"',
                                          strip_tags($html, '<img>')
                                          );
                $this->imageSet = true;
                unset($elements[$line]);
            }
            //見出しをセット
            else if ( ! $this->headingSet)
            {
                if (preg_match('{ <h }mx', $html))
                {
                    $this->heading = preg_replace('{ <h([1-6])(.*?>) }mx', '<h\1 class="media-heading"\2', $html);
                    $this->headingSet = true;
                    unset($elements[$line]);
                }

                if ( ! $this->imageSet)
                {
                    //最後の行をチェック
                    $html = \Parser::parse($elements[$max_line]);
                    if (preg_match('{ <img\b.*?> }mx', $html))
                    {
                        $this->image = str_replace(
                                                  '<img', '<img class="media-object"',
                                                  strip_tags($html, '<img>')
                                                  );
                        $this->align = 'pull-right';
                        unset($elements[$max_line]);
                    }
                }
                break;
            }
            $content_md = $content_md.$line."\n";
        }

        // 残りをparse
        $this->content = \Parser::parse(join("\n", $elements));

        # all parameter trimed.
        $this->image = trim($this->image);
        $this->heading = trim($this->heading);
        $this->content = trim($this->content);

        $result = '<div class="media">'
              . '<span class="'.$this->align.'">'.$this->image.'</span>'
              . '<div class="media-body">'.$this->heading.$this->content.'</div></div>';

        return $result;
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