<?php
namespace Toiee\haik\Plugins\Thumbnails;

use Toiee\haik\Plugins\Cols\ColsPlugin;

class ThumbnailsPlugin extends ColsPlugin {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * get formated html
     * @params array $data col options data
     * @return string $html formated col html
     */
    protected function format($data)
    {
        foreach ($data['data'] as $key => $col)
        {
            $elements = preg_split('{ \n+ }mx', trim($col['body']));

            $top_line = \Parser::parse($elements[0]);
            if (strpos($top_line, '<img') !== FALSE)
            {
                $data['data'][$key]['image'] = trim(strip_tags($top_line,'<a><img>'));
                array_shift($elements);
            }
            
            $body = join("\n", $elements);
            $data['data'][$key]['body'] = \Parser::parse($body);
        }

        return self::renderView('template', $data);
    }
}