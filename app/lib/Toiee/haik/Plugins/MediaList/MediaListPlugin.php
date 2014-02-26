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
        # Initialize variables.
        $this->setUp();
        # First, split $body with break.
        $elements = preg_split('{ \n+ }mx', trim($medialist));
        # Second, each split body convert.
        foreach ($elements as $element)
        {
            $parsed_elements[] = \Parser::parse($element);
        }
        # Start check each parameters converted.
        # check first parameter has image tag.
        if (strstr($parsed_elements[0], '<img'))
        {
            $this->image = str_replace('<img', '<img class="media-object"', $parsed_elements[0]);
            # check next parameter has heading tag.
            if (strstr($parsed_elements[1], '<h'))
            {
                $this->heading = preg_replace('{ <h([1-6])(.*?>) }mx', '<h\1 class="media-heading"\2', $parsed_elements[1]);
                array_splice($parsed_elements, 0, 2);
                # remain content join to create content.
                $this->content = join("\n", $parsed_elements);
            }
            else
            {
                # no heading & image tag is first parameter, delete image tag to create content. 
                array_shift($parsed_elements);
                $this->content = join("\n", $parsed_elements);
            }
        }
        # check last parameter has image tag.
        else if (strstr(end($parsed_elements), '<img'))
        {
            # change pull-left to right.
            $this->align = "pull-right";
            $this->image = str_replace('<img', '<img class="media-object"', end($parsed_elements));
            # check first parameter has heading tag
            if (strstr($parsed_elements[0], '<h'))
            {
                $this->heading = preg_replace('{ <h([1-6])(.*?>) }mx', '<h\1 class="media-heading"\2', $parsed_elements[0]);
                # delete image tag & heading tag to create content.
                array_shift($parsed_elements);
                array_pop($parsed_elements);
                $this->content = join("\n", $parsed_elements);
            }
            else
            {
                # no heading & image tag is last parameter, delete image tag to create content.
                array_pop($parsed_elements);
                $this->content = join("\n", $parsed_elements);
            }
        }
        # check first parameter has heading tag & last parameter is NOT image tag.
        else if (strstr($parsed_elements[0], '<h') && ! strstr(end($parsed_elements), '<img'))
        {
            $this->heading = preg_replace('{ <h([1-6])(.*?>) }mx', '<h\1 class="media-heading"\2', $parsed_elements[0]);
            # delete heading tag to create content.
            array_shift($parsed_elements);
            $this->content = join("\n", $parsed_elements);
        }
        # no image, no heading, all parameters are content.
        else
        {
            $this->content = join("\n", $parsed_elements);
        }

        # create only image tag.
        $this->image = strip_tags($this->image, '<img>');

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