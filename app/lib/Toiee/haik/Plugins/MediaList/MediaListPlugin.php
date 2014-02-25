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
        # set default parameter.
        $align = 'pull-left';
        $image = '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">';
        $heading = $content = "";

        # First, split $body with break.
        $split_body = preg_split('{ \n+ }mx', trim($body));
        # Second, each split body convert.
        foreach ($split_body as $s)
        {
            $split[] = \Parser::parse($s);
        }
        # Start check each parameters converted.
        # check first parameter has image tag.
        if (strstr($split[0], '<img'))
        {
            $image = str_replace('<img', '<img class="media-object"', $split[0]);
            # check next parameter has heading tag.
            if (strstr($split[1], '<h'))
            {
                $heading = preg_replace('{ <h([1-6])(.*?>) }mx', '<h\1 class="media-heading"\2', $split[1]);
                array_splice($split, 0, 2);
                # remain content join to create content.
                $content = implode($split);
            }
            else
            {
                # no heading & image tag is first parameter, delete image tag to create content. 
                array_shift($split);
                $content = implode($split);
            }
        }
        # check last parameter has image tag.
        else if (strstr(end($split), '<img'))
        {
            # change pull-left to right.
            $align = "pull-right";
            $image = str_replace('<img', '<img class="media-object"', end($split));
            # check first parameter has heading tag
            if (strstr($split[0], '<h'))
            {
                $heading = preg_replace('{ <h([1-6])(.*?>) }mx', '<h\1 class="media-heading"\2', $split[0]);
                # delete image tag & heading tag to create content.
                array_shift($split);
                array_pop($split);
                $content = implode($split);
            }
            else
            {
                # no heading & image tag is last parameter, delete image tag to create content.
                array_pop($split);
                $content = implode($split);
            }
        }
        # check first parameter has heading tag & last parameter is NOT image tag.
        else if (strstr($split[0], '<h') && ! strstr(end($split), '<img'))
        {
            $heading = preg_replace('{ <h([1-6])(.*?>) }mx', '<h\1 class="media-heading"\2', $split[0]);
            # delete heading tag to create content.
            array_shift($split);
            $content = implode($split);
        }
        # no image, no heading, all parameters are content.
        else
        {
            $content = implode($split);
        }

        # create only image tag.
        $image = strip_tags($image, '<img>');

        # all parameter trimed.
        $image = trim($image); $heading = trim($heading); $content = trim($content);
        $html = '<div class="media">'
              . '<span class="'.$align.'">'.$image.'</span>'
              . '<div class="media-body">'.$heading.$content.'</div></div>';
        return $html;
    }
}