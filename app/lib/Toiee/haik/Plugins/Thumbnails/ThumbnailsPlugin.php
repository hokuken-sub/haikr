<?php
namespace Toiee\haik\Plugins\Thumbnails;

use Toiee\haik\Plugins\Cols\ColsPlugin;

class ThumbnailsPlugin extends ColsPlugin {

    const COL_FORMAT_EACH = <<< EOD
  <div class="%s" style="%s">
    <div class="thumbnail">
      %s
      <div class="caption">
        %s
      </div>
    </div>
  </div>
EOD;

    const ROW_FORMAT      = <<< EOD
<div class="haik-plugin-thumbnails row %s">
%s
</div>
EOD;

    public function __construct()
    {
        parent::__construct();
    }


    protected function makeHtml($data)
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

        \View::addLocation(__DIR__.'/views');
        \View::addNamespace('ThumbnailsPlugin', __DIR__.'/views');
        $html = \View::make('templete', $data)->render();

        return $html;

    }


    /**
     * get formated col html
     * @params array $data col options data
     * @return string $html formated col html
     */
    protected function getColHtml($data)
    {
        $body = $data[2];
        $elements = preg_split('{ \n+ }mx', trim($body));
        
        $image = '';
        $top_line = \Parser::parse($elements[0]);
        if (strpos($top_line, '<img') !== FALSE)
        {
            $image = trim(strip_tags($top_line,'<a><img>'));
            array_shift($elements);
        }
        
        $body = join("\n", $elements);
        $body = \Parser::parse($body);

        $html = sprintf(self::COL_FORMAT_EACH, $data[0], $data[1], $image, $body);
        return $html;
    }

}