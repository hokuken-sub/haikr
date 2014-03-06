<?php
use Toiee\haik\Plugins\Slide\SlidePlugin;

class SlidePluginTest extends TestCase {

    public function testConvertMethodExists()
    {
        $this->assertInternalType('string', with(new SlidePlugin)->convert());
    }

    public function testSlideWithNoParams()
    {
        # This is the test of slide with body has just one line.
        $slide_obj = new SlidePlugin();
        $id = $slide_obj->getSlideId();

        $one_line = array(
            'slide'  => array(),
            'assert' => '<div id="haik_plugin_slide'.$id.'" class="haik-plugin-slide carousel slide" data-ride="carousel">'."\n"
                      . '  <!-- Wrapper for slides -->'."\n"
                      . '  <div class="carousel-inner">'."\n"
                      . '    <div class="item active">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3>First Slide</h3>'."\n"
                      . '        <p>This is first slide.</p>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '  </div>'."\n"
                      . '</div>',
        );

        $body = 'http://placehold.jp/1000x400.png,'.'First Slide,'.'This is first slide.';

        $expect_return = preg_replace('/\n| {2,}/', '', trim($one_line['assert']));
        $actual_return = $slide_obj->convert($one_line['slide'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);


        # This is the test of slide with body has some lines.
        $slide_obj = new SlidePlugin();
        $id = $slide_obj->getSlideId();

        $some_lines = array(
            'slide'  => array(),
            'assert' => '<div id="haik_plugin_slide'.$id.'" class="haik-plugin-slide carousel slide" data-ride="carousel">'."\n"
                      . '  <!-- Indicators -->'."\n"
                      . '  <ol class="carousel-indicators">'."\n"
                      . '    <li data-target="#haik_plugin_slide'.$id.'" data-slide-to="0"></li>'."\n"
                      . '    <li data-target="#haik_plugin_slide'.$id.'" data-slide-to="1"></li>'."\n"
                      . '    <li data-target="#haik_plugin_slide'.$id.'" data-slide-to="2"></li>'."\n"
                      . '  </ol>'."\n"
                      . '  <!-- Wrapper for slides -->'."\n"
                      . '  <div class="carousel-inner">'."\n"
                      . '    <div class="item active">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3>First Slide</h3>'."\n"
                      . '        <p>This is first slide.</p>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '    <div class="item">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3>Second Slide</h3>'."\n"
                      . '        <p>This is second slide.</p>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '    <div class="item">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3>Third Slide</h3>'."\n"
                      . '        <p>This is third slide.</p>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '  </div>'."\n"
                      . '  <!-- Controls -->'."\n"
                      . '  <a class="left carousel-control" href="#haik_plugin_slide'.$id.'" data-slide="prev">'."\n"
                      . '    <span class="glyphicon glyphicon-chevron-left"></span>'."\n"
                      . '  </a>'."\n"
                      . '  <a class="right carousel-control" href="#haik_plugin_slide'.$id.'" data-slide="next">'."\n"
                      . '    <span class="glyphicon glyphicon-chevron-right"></span>'."\n"
                      . '  </a>'."\n"
                      . '</div>',
        );

        $body = 'http://placehold.jp/1000x400.png,'.'First Slide,'.'This is first slide.'."\n"
              . 'http://placehold.jp/1000x400.png,'.'Second Slide,'.'This is second slide.'."\n"
              . 'http://placehold.jp/1000x400.png,'.'Third Slide,'.'This is third slide.';

        $expect_return = preg_replace('/\n| {2,}/', '', trim($some_lines['assert']));
        $actual_return = $slide_obj->convert($some_lines['slide'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);


        # This is the test of slide with body has markdown.
        $slide_obj = new SlidePlugin();
        $id = $slide_obj->getSlideId();

        $markdown = array(
            'slide'  => array(),
            'assert' => '<div id="haik_plugin_slide'.$id.'" class="haik-plugin-slide carousel slide" data-ride="carousel">'."\n"
                      . '  <!-- Indicators -->'."\n"
                      . '  <ol class="carousel-indicators">'."\n"
                      . '    <li data-target="#haik_plugin_slide'.$id.'" data-slide-to="0"></li>'."\n"
                      . '    <li data-target="#haik_plugin_slide'.$id.'" data-slide-to="1"></li>'."\n"
                      . '    <li data-target="#haik_plugin_slide'.$id.'" data-slide-to="2"></li>'."\n"
                      . '  </ol>'."\n"
                      . '  <!-- Wrapper for slides -->'."\n"
                      . '  <div class="carousel-inner">'."\n"
                      . '    <div class="item active">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3>First Slide</h3>'."\n"
                      . '        <p>This is <strong>first</strong> slide.</p>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '    <div class="item">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3>Second Slide</h3>'."\n"
                      . '        <p>This is <a href="http://google.com">second</a> slide.</p>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '    <div class="item">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3>Third Slide</h3>'."\n"
                      . '        <blockquote><p>This is third slide.</p></blockquote>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '  </div>'."\n"
                      . '  <!-- Controls -->'."\n"
                      . '  <a class="left carousel-control" href="#haik_plugin_slide'.$id.'" data-slide="prev">'."\n"
                      . '    <span class="glyphicon glyphicon-chevron-left"></span>'."\n"
                      . '  </a>'."\n"
                      . '  <a class="right carousel-control" href="#haik_plugin_slide'.$id.'" data-slide="next">'."\n"
                      . '    <span class="glyphicon glyphicon-chevron-right"></span>'."\n"
                      . '  </a>'."\n"
                      . '</div>',
        );

        $body = 'http://placehold.jp/1000x400.png,'.'###First Slide,'.'This is **first** slide.'."\n"
              . 'http://placehold.jp/1000x400.png,'.'# Second Slide,'.'This is [second](http://google.com) slide.'."\n"
              . 'http://placehold.jp/1000x400.png,'.'######Third Slide######,'.'>This is third slide.';

        $expect_return = preg_replace('/\n| {2,}/', '', trim($markdown['assert']));
        $actual_return = $slide_obj->convert($markdown['slide'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);


        # This is the test of slide with body has row html.
        $slide_obj = new SlidePlugin();
        $id = $slide_obj->getSlideId();

        $row_html = array(
            'slide'  => array(),
            'assert' => '<div id="haik_plugin_slide'.$id.'" class="haik-plugin-slide carousel slide" data-ride="carousel">'."\n"
                      . '  <!-- Indicators -->'."\n"
                      . '  <ol class="carousel-indicators">'."\n"
                      . '    <li data-target="#haik_plugin_slide'.$id.'" data-slide-to="0"></li>'."\n"
                      . '    <li data-target="#haik_plugin_slide'.$id.'" data-slide-to="1"></li>'."\n"
                      . '    <li data-target="#haik_plugin_slide'.$id.'" data-slide-to="2"></li>'."\n"
                      . '  </ol>'."\n"
                      . '  <!-- Wrapper for slides -->'."\n"
                      . '  <div class="carousel-inner">'."\n"
                      . '    <div class="item active">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3>First Slide</h3>'."\n"
                      . '        <p>This is <strong>first</strong> slide.</p>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '    <div class="item">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3>Second Slide</h3>'."\n"
                      . '        <p>This is <a href="http://google.com">second</a> slide.</p>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '    <div class="item">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3><strong>Third Slide</strong></h3>'."\n"
                      . '        <blockquote>This is third slide.</blockquote>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '  </div>'."\n"
                      . '  <!-- Controls -->'."\n"
                      . '  <a class="left carousel-control" href="#haik_plugin_slide'.$id.'" data-slide="prev">'."\n"
                      . '    <span class="glyphicon glyphicon-chevron-left"></span>'."\n"
                      . '  </a>'."\n"
                      . '  <a class="right carousel-control" href="#haik_plugin_slide'.$id.'" data-slide="next">'."\n"
                      . '    <span class="glyphicon glyphicon-chevron-right"></span>'."\n"
                      . '  </a>'."\n"
                      . '</div>',
        );

        $body = 'http://placehold.jp/1000x400.png,'.'<h1>First Slide</h1>,'.'This is <strong>first</strong> slide.'."\n"
              . 'http://placehold.jp/1000x400.png,'.'<h6>Second Slide</h6>,'.'This is <a href="http://google.com">second</a> slide.'."\n"
              . 'http://placehold.jp/1000x400.png,'.'<strong>Third Slide</strong>,'.'<blockquote>This is third slide.</blockquote>';

        $expect_return = preg_replace('/\n| {2,}/', '', trim($row_html['assert']));
        $actual_return = $slide_obj->convert($row_html['slide'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);


        # This is the test of slide with body that one is no title, anoter is no caption, another is both none.
        $slide_obj = new SlidePlugin();
        $id = $slide_obj->getSlideId();

        $with_blank = array(
            'slide'  => array(),
            'assert' => '<div id="haik_plugin_slide'.$id.'" class="haik-plugin-slide carousel slide" data-ride="carousel">'."\n"
                      . '  <!-- Indicators -->'."\n"
                      . '  <ol class="carousel-indicators">'."\n"
                      . '    <li data-target="#haik_plugin_slide'.$id.'" data-slide-to="0"></li>'."\n"
                      . '    <li data-target="#haik_plugin_slide'.$id.'" data-slide-to="1"></li>'."\n"
                      . '    <li data-target="#haik_plugin_slide'.$id.'" data-slide-to="2"></li>'."\n"
                      . '  </ol>'."\n"
                      . '  <!-- Wrapper for slides -->'."\n"
                      . '  <div class="carousel-inner">'."\n"
                      . '    <div class="item active">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <p>This is first slide.</p>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '    <div class="item">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3>Second Slide</h3>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '    <div class="item">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '    </div>'."\n"
                      . '  </div>'."\n"
                      . '  <!-- Controls -->'."\n"
                      . '  <a class="left carousel-control" href="#haik_plugin_slide'.$id.'" data-slide="prev">'."\n"
                      . '    <span class="glyphicon glyphicon-chevron-left"></span>'."\n"
                      . '  </a>'."\n"
                      . '  <a class="right carousel-control" href="#haik_plugin_slide'.$id.'" data-slide="next">'."\n"
                      . '    <span class="glyphicon glyphicon-chevron-right"></span>'."\n"
                      . '  </a>'."\n"
                      . '</div>',
        );

        $body = 'http://placehold.jp/1000x400.png,'.','.'This is first slide.'."\n"
              . 'http://placehold.jp/1000x400.png,'.'Second Slide,'."\n"
              . 'http://placehold.jp/1000x400.png';

        $expect_return = preg_replace('/\n| {2,}/', '', trim($with_blank['assert']));
        $actual_return = $slide_obj->convert($with_blank['slide'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);
    }

    public function testTooManyCommas()
    {
        # This is the test of slide with body has too many commas.
        # Expect that ignore after 4th elements.
        $slide_obj = new SlidePlugin();
        $id = $slide_obj->getSlideId();

        $one_line = array(
            'slide'  => array(),
            'assert' => '<div id="haik_plugin_slide'.$id.'" class="haik-plugin-slide carousel slide" data-ride="carousel">'."\n"
                      . '  <!-- Wrapper for slides -->'."\n"
                      . '  <div class="carousel-inner">'."\n"
                      . '    <div class="item active">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3>First Slide</h3>'."\n"
                      . '        <p>This is first slide.</p>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '  </div>'."\n"
                      . '</div>',
        );

        $body = 'http://placehold.jp/1000x400.png,'.'First Slide,'.'This is first slide.,'.'too many commas!!!';

        $expect_return = preg_replace('/\n| {2,}/', '', trim($one_line['assert']));
        $actual_return = $slide_obj->convert($one_line['slide'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);
    }

    public function testContainEmptyLine()
    {
        # This is the test of slide with body has empty line.
        $slide_obj = new SlidePlugin();
        $id = $slide_obj->getSlideId();

        $some_lines = array(
            'slide'  => array(),
            'assert' => '<div id="haik_plugin_slide'.$id.'" class="haik-plugin-slide carousel slide" data-ride="carousel">'."\n"
                      . '  <!-- Indicators -->'."\n"
                      . '  <ol class="carousel-indicators">'."\n"
                      . '    <li data-target="#haik_plugin_slide'.$id.'" data-slide-to="0"></li>'."\n"
                      . '    <li data-target="#haik_plugin_slide'.$id.'" data-slide-to="1"></li>'."\n"
                      . '    <li data-target="#haik_plugin_slide'.$id.'" data-slide-to="2"></li>'."\n"
                      . '  </ol>'."\n"
                      . '  <!-- Wrapper for slides -->'."\n"
                      . '  <div class="carousel-inner">'."\n"
                      . '    <div class="item active">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3>First Slide</h3>'."\n"
                      . '        <p>This is first slide.</p>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '    <div class="item">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3>Second Slide</h3>'."\n"
                      . '        <p>This is second slide.</p>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '    <div class="item">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3>Third Slide</h3>'."\n"
                      . '        <p>This is third slide.</p>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '  </div>'."\n"
                      . '  <!-- Controls -->'."\n"
                      . '  <a class="left carousel-control" href="#haik_plugin_slide'.$id.'" data-slide="prev">'."\n"
                      . '    <span class="glyphicon glyphicon-chevron-left"></span>'."\n"
                      . '  </a>'."\n"
                      . '  <a class="right carousel-control" href="#haik_plugin_slide'.$id.'" data-slide="next">'."\n"
                      . '    <span class="glyphicon glyphicon-chevron-right"></span>'."\n"
                      . '  </a>'."\n"
                      . '</div>',
        );

        $body = 'http://placehold.jp/1000x400.png,'.'First Slide,'.'This is first slide.'."\n"
              . "     \n"
              . 'http://placehold.jp/1000x400.png,'.'Second Slide,'.'This is second slide.'."\n"
              . "     \n"
              . 'http://placehold.jp/1000x400.png,'.'Third Slide,'.'This is third slide.';

        $expect_return = preg_replace('/\n| {2,}/', '', trim($some_lines['assert']));
        $actual_return = $slide_obj->convert($some_lines['slide'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);
    }

    public function testSlideWithParamsForButtons()
    {
        # This is the test of slide with nobutton param.
        $slide_obj = new SlidePlugin();
        $id = $slide_obj->getSlideId();

        $some_lines = array(
            'slide'  => array('nobutton'),
            'assert' => '<div id="haik_plugin_slide'.$id.'" class="haik-plugin-slide carousel slide" data-ride="carousel">'."\n"
                      . '  <!-- Wrapper for slides -->'."\n"
                      . '  <div class="carousel-inner">'."\n"
                      . '    <div class="item active">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3>First Slide</h3>'."\n"
                      . '        <p>This is first slide.</p>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '    <div class="item">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3>Second Slide</h3>'."\n"
                      . '        <p>This is second slide.</p>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '    <div class="item">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3>Third Slide</h3>'."\n"
                      . '        <p>This is third slide.</p>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '  </div>'."\n"
                      . '</div>',
        );

        $body = 'http://placehold.jp/1000x400.png,'.'First Slide,'.'This is first slide.'."\n"
              . 'http://placehold.jp/1000x400.png,'.'Second Slide,'.'This is second slide.'."\n"
              . 'http://placehold.jp/1000x400.png,'.'Third Slide,'.'This is third slide.';

        $expect_return = preg_replace('/\n| {2,}/', '', trim($some_lines['assert']));
        $actual_return = $slide_obj->convert($some_lines['slide'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);


        # This is the test of slide with noindicator param.
        $slide_obj = new SlidePlugin();
        $id = $slide_obj->getSlideId();

        $some_lines = array(
            'slide'  => array('noindicator'),
            'assert' => '<div id="haik_plugin_slide'.$id.'" class="haik-plugin-slide carousel slide" data-ride="carousel">'."\n"
                      . '  <!-- Wrapper for slides -->'."\n"
                      . '  <div class="carousel-inner">'."\n"
                      . '    <div class="item active">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3>First Slide</h3>'."\n"
                      . '        <p>This is first slide.</p>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '    <div class="item">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3>Second Slide</h3>'."\n"
                      . '        <p>This is second slide.</p>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '    <div class="item">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3>Third Slide</h3>'."\n"
                      . '        <p>This is third slide.</p>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '  </div>'."\n"
                      . '  <!-- Controls -->'."\n"
                      . '  <a class="left carousel-control" href="#haik_plugin_slide'.$id.'" data-slide="prev">'."\n"
                      . '    <span class="glyphicon glyphicon-chevron-left"></span>'."\n"
                      . '  </a>'."\n"
                      . '  <a class="right carousel-control" href="#haik_plugin_slide'.$id.'" data-slide="next">'."\n"
                      . '    <span class="glyphicon glyphicon-chevron-right"></span>'."\n"
                      . '  </a>'."\n"
                      . '</div>',
        );

        $body = 'http://placehold.jp/1000x400.png,'.'First Slide,'.'This is first slide.'."\n"
              . 'http://placehold.jp/1000x400.png,'.'Second Slide,'.'This is second slide.'."\n"
              . 'http://placehold.jp/1000x400.png,'.'Third Slide,'.'This is third slide.';

        $expect_return = preg_replace('/\n| {2,}/', '', trim($some_lines['assert']));
        $actual_return = $slide_obj->convert($some_lines['slide'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);


        # This is the test of slide with noslidebutton param.
        $slide_obj = new SlidePlugin();
        $id = $slide_obj->getSlideId();

        $some_lines = array(
            'slide'  => array('noslidebutton'),
            'assert' => '<div id="haik_plugin_slide'.$id.'" class="haik-plugin-slide carousel slide" data-ride="carousel">'."\n"
                      . '  <!-- Indicators -->'."\n"
                      . '  <ol class="carousel-indicators">'."\n"
                      . '    <li data-target="#haik_plugin_slide'.$id.'" data-slide-to="0"></li>'."\n"
                      . '    <li data-target="#haik_plugin_slide'.$id.'" data-slide-to="1"></li>'."\n"
                      . '    <li data-target="#haik_plugin_slide'.$id.'" data-slide-to="2"></li>'."\n"
                      . '  </ol>'."\n"
                      . '  <!-- Wrapper for slides -->'."\n"
                      . '  <div class="carousel-inner">'."\n"
                      . '    <div class="item active">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3>First Slide</h3>'."\n"
                      . '        <p>This is first slide.</p>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '    <div class="item">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3>Second Slide</h3>'."\n"
                      . '        <p>This is second slide.</p>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '    <div class="item">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3>Third Slide</h3>'."\n"
                      . '        <p>This is third slide.</p>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '  </div>'."\n"
                      . '</div>',
        );

        $body = 'http://placehold.jp/1000x400.png,'.'First Slide,'.'This is first slide.'."\n"
              . 'http://placehold.jp/1000x400.png,'.'Second Slide,'.'This is second slide.'."\n"
              . 'http://placehold.jp/1000x400.png,'.'Third Slide,'.'This is third slide.';

        $expect_return = preg_replace('/\n| {2,}/', '', trim($some_lines['assert']));
        $actual_return = $slide_obj->convert($some_lines['slide'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);


        # This is the test of slide with noindicator & noslidebutton params.
        $slide_obj = new SlidePlugin();
        $id = $slide_obj->getSlideId();

        $some_lines = array(
            'slide'  => array('noindicator', 'noslidebutton'),
            'assert' => '<div id="haik_plugin_slide'.$id.'" class="haik-plugin-slide carousel slide" data-ride="carousel">'."\n"
                      . '  <!-- Wrapper for slides -->'."\n"
                      . '  <div class="carousel-inner">'."\n"
                      . '    <div class="item active">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3>First Slide</h3>'."\n"
                      . '        <p>This is first slide.</p>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '    <div class="item">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3>Second Slide</h3>'."\n"
                      . '        <p>This is second slide.</p>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '    <div class="item">'."\n"
                      . '      <img src="http://placehold.jp/1000x400.png" alt="">'."\n"
                      . '      <div class="carousel-caption">'."\n"
                      . '        <h3>Third Slide</h3>'."\n"
                      . '        <p>This is third slide.</p>'."\n"
                      . '      </div>'."\n"
                      . '    </div>'."\n"
                      . '  </div>'."\n"
                      . '</div>',
        );

        $body = 'http://placehold.jp/1000x400.png,'.'First Slide,'.'This is first slide.'."\n"
              . 'http://placehold.jp/1000x400.png,'.'Second Slide,'.'This is second slide.'."\n"
              . 'http://placehold.jp/1000x400.png,'.'Third Slide,'.'This is third slide.';

        $expect_return = preg_replace('/\n| {2,}/', '', trim($some_lines['assert']));
        $actual_return = $slide_obj->convert($some_lines['slide'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);
    }
}