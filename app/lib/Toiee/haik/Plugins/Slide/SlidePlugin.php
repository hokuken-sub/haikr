<?php
namespace Toiee\haik\Plugins\Slide;

use Toiee\haik\Plugins\Plugin;

class SlidePlugin extends Plugin {

    const DEFAULT_IMAGE_URL = "http://placehold.jp/900x500.png";

    protected static $slideId = 0;

    protected $id;
    protected $slideData = array();
    protected $indicatorsSet;
    protected $controlsSet;

    protected $params;
    protected $body;

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
        $this->params = $params;
        $this->body = $body;

        $this->createSlideData();
        $this->checkParams();

        $data = array(
            'slideId'         => $this->id,
            'isIndicatorsSet' => $this->indicatorsSet,
            'isControlsSet'   => $this->controlsSet,
            'slideData'       => $this->slideData
        );

        return self::renderView('carousel', $data);
    }

    protected function createSlideData()
    {
        $lines = preg_split('/\n+/', trim($this->body));
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
                $this->slideData[$i]['image'] = trim($slide_elements[0]);
            }
            else
            {
                $this->slideData[$i]['image'] = self::DEFAULT_IMAGE_URL;
            }

            if (isset($slide_elements[1]) && $slide_elements[1] != '')
            {
                $slide_elements[1] = trim($slide_elements[1]);

                # Check $slide_elements[1] is heading written with markdown.
                if (preg_match('/^#{1,6}/', $slide_elements[1]))
                {
                    # Trim '#' to set title with '###'.
                    $title = preg_replace('/^#{1,6}/', '', $slide_elements[1]);
                    $this->slideData[$i]['title'] = '###'.$title;
                }

                # Check $slide_elements[1] is heading written with row html.
                else if (preg_match('{ ^<(h[1-6])(.*?>)(.*?)</\1> }mx', $slide_elements[1]))
                {
                    # Change <h...> elements to <h3>.
                    $this->slideData[$i]['title'] = preg_replace(
                                                                '{ ^<(h[1-6])(.*?>)(.*?)</\1> }mx',
                                                                '<h3\2\3</h3>',
                                                                $slide_elements[1]
                                                                );
                }
                else
                {
                    # Set title with "###" to create <h3> heading.
                    $this->slideData[$i]['title'] = '###'.$slide_elements[1];
                }
                $this->slideData[$i]['isset_caption'] = true;
            }

            if (isset($slide_elements[2]) && $slide_elements[2] != '')
            {
                $this->slideData[$i]['caption'] = trim($slide_elements[2]);
                $this->slideData[$i]['isset_caption'] = true;
            }

            if ( ! isset($slide_elements[1], $slide_elements[2]) || $slide_elements[1] == '' && $slide_elements[2] == '')
            {
                $this->slideData[$i]['isset_caption'] = false;
            }
        }
    }

    protected function checkParams()
    {
        foreach ($this->params as $i => $param)
        {
            switch ($param)
            {
                case 'nobutton':
                    $this->indicatorsSet = $this->controlsSet = false;
                    break;
                case 'noindicator':
                    $this->indicatorsSet = false;
                    break;
                case 'noslidebutton':
                    $this->controlsSet = false;
                    break;
            }
        }
    }
}