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

    protected function createMediaList($medialist)
    {
        $this->setUp();

        $elements = preg_split('{ \n+ }mx', trim($medialist));
        foreach ($elements as $element)
        {
            $parsed_elements[] = \Parser::parse($element);
        }
        if (preg_match('{ <img.*?>< }mx', $parsed_elements[0]))
        {
            $this->image = str_replace('<img', '<img class="media-object"', $parsed_elements[0]);
            $this->image = strip_tags($this->image, '<img>');
            $searches[] = $elements[0];
            if (preg_match('{ <h }mx', $parsed_elements[1]))
            {
                $this->heading = preg_replace('{ <h([1-6])(.*?>) }mx', '<h\1 class="media-heading"\2', $parsed_elements[1]);
                $searches[] = $elements[1];
                $content = str_replace($searches, '', $elements);
                $this->content = \Parser::parse(join("\n", $content));
            }
            else
            {
                $content = str_replace($searches, '', $elements);
                $this->content = \Parser::parse(join("\n", $content));
            }
        }
        else if (preg_match('{ <img.*?>< }mx', end($parsed_elements)))
        {
            $this->align = "pull-right";
            $this->image = str_replace('<img', '<img class="media-object"', end($parsed_elements));
            $this->image = strip_tags($this->image, '<img>');
            $searches[] = end($elements);
            if (preg_match('{ <h }mx', $parsed_elements[0]))
            {
                $this->heading = preg_replace('{ <h([1-6])(.*?>) }mx', '<h\1 class="media-heading"\2', $parsed_elements[0]);
                $searches[] = $elements[0];
                $content = str_replace($searches, '', $elements);
                $this->content = \Parser::parse(join("\n", $content));
            }
            else
            {
                $content = str_replace($searches, '', $elements);
                $this->content = \Parser::parse(join("\n", $content));
            }
        }
        else if (preg_match('{ <h }mx', $parsed_elements[0]))
        {
            $this->heading = preg_replace('{ <h([1-6])(.*?>) }mx', '<h\1 class="media-heading"\2', $parsed_elements[0]);
            $searches[] = $elements[0];
            $content = str_replace($searches, '', $elements);
            $this->content = \Parser::parse(join("\n", $content));
        }
        else
        {
            $this->content = \Parser::parse($medialist);
        }
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