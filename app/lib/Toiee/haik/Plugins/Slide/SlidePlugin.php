<?php
namespace Toiee\haik\Plugins\Slide;

use Toiee\haik\Plugins\Plugin;

class SlidePlugin extends Plugin {

    const DEFAULT_IMAGE_URL = "http://placehold.jp/900x500.png";

    protected static $slideId = 0;

    protected $id;
    protected $images = array();
    protected $titles = array();
    protected $captions = array();
    protected $indicatorsSet;
    protected $controlsSet;
    protected $captionsSet = array();

    # This is slide_id getter.
    public function getSlideId()
    {
        return $this->id;
    }

    public function __construct()
    {
        self::$slideId++;
        $this->id = self::$slideId;
        $this->indicatorsSet = $this->controlsSet = true;
    }

    public function convert($params = array(), $body = '')
    {
        $lines = preg_split('/\n+/', trim($body));
        $line_count = count($lines);
        if ($line_count == 1)
        {
            $this->indicatorsSet = $this->controlsSet = false;
        }
        foreach ($lines as $i => $line)
        {
            $slide_elements = str_getcsv($line, ',', '"', '\\');
            if (isset($slide_elements[0]) && $slide_elements[0] != '')
            {
                $this->images[$i] = trim($slide_elements[0]);
            }
            else
            {
                $this->images[$i] = self::DEFAULT_IMAGE_URL;
            }

            if (isset($slide_elements[1]) && $slide_elements[1] != '')
            {
                $slide_elements[1] = trim($slide_elements[1]);

                # Check $slide_elements[1] is heading written with markdown.
                if (preg_match('/^#{1,6}/', $slide_elements[1]))
                {
                    # Trim '#' to set title with '###'.
                    $title = preg_replace('/^#{1,6}/', '', $slide_elements[1]);
                    $this->titles[$i] = '###'.$title;
                }

                # Check $slide_elements[1] is heading written with row html.
                else if (preg_match('{ ^<(h[1-6])(.*?>)(.*?)</\1> }mx', $slide_elements[1]))
                {
                    # Change <h...> elements to <h3>.
                    $this->titles[$i] = preg_replace(
                                                  '{ ^<(h[1-6])(.*?>)(.*?)</\1> }mx',
                                                  '<h3\2\3</h3>',
                                                  $slide_elements[1]
                                                  );
                }
                else
                {
                    # Set title with "###" to create <h3> heading.
                    $this->titles[$i] = '###'.$slide_elements[1];
                }
                $this->captionsSet[$i] = true;
            }

            if (isset($slide_elements[2]) && $slide_elements[2] != '')
            {
                $this->captions[$i] = trim($slide_elements[2]);
                $this->captionsSet[$i] = true;
            }

            if ( ! isset($slide_elements[1], $slide_elements[2]) || $slide_elements[1] == '' && $slide_elements[2] == '')
            {
                $this->captionsSet[$i] = false;                
            }
        }

        $data = array(
            'slideId'         => $this->id,
            'slides'          => $line_count,
            'isIndicatorsSet' => $this->indicatorsSet,
            'isControlsSet'   => $this->controlsSet,
            'isCaptionsSet'   => $this->captionsSet,
            'imageSources'    => $this->images,
            'titles'          => $this->titles,
            'captions'        => $this->captions
        );

        return self::renderView('carousel', $data);
    }
}