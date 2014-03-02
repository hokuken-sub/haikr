<?php
namespace Toiee\haik\Plugins\MediaList;

use Toiee\haik\Plugins\Plugin;

class MediaListPlugin extends Plugin {

    protected $align;
    protected $image;
    protected $heading;
    protected $content;
    protected $html;

    public function setUp()
    {
        $this->align = 'pull-left';
        $this->image = '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">';
        $this->heading = $this->content = $this->html = '';
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
        foreach ($medialists as $medialist)
        {
            $this->html = $this->html.$this->createMediaList($medialist);
        }
        return $this->html;
    }

    protected function createMediaList($md)
    {
        $this->setUp();

        $splited_md = explode("\n", trim($md));
        $image_count = 0;
        $head_count = 0;
        $content_md = "";
        foreach ($splited_md as $i => $line)
        {
            if (\Parser::parse($line) == "\n")
            {
                $content_md = $content_md."\n";
                continue;
            }
            if (preg_match('{ <img.*?>< }mx', \Parser::parse($line)) && $i == 0 && $image_count == 0)
            {
                $image_count++;
                $this->image = str_replace('<img', '<img class="media-object"', \Parser::parse($line));
                $this->image = strip_tags($this->image, '<img>');
                continue;
            }

            if (preg_match('{ <h }mx', \Parser::parse($line)) && $head_count == 0)
            {
                $head_count++;
                $this->heading = preg_replace('{ <h([1-6])(.*?>) }mx', '<h\1 class="media-heading"\2', \Parser::parse($line));
                continue;
            }

            end($splited_md);
            if (preg_match('{ <img.*?>< }mx', \Parser::parse($line)) && $i == key($splited_md) && $image_count == 0)
            {
                $image_count++;
                $this->align = "pull-right";
                $this->image = str_replace('<img', '<img class="media-object"', \Parser::parse($line));
                $this->image = strip_tags($this->image, '<img>');
                continue;
            }
            $content_md = $content_md.$line."\n";
        }
        $this->content = \Parser::parse($content_md);

        # all parameter trimed.
        $this->image = trim($this->image);
        $this->heading = trim($this->heading);
        $this->content = trim($this->content);

        $result = '<div class="media">'
              . '<span class="'.$this->align.'">'.$this->image.'</span>'
              . '<div class="media-body">'.$this->heading.$this->content.'</div></div>';

        return $result;
    }
}