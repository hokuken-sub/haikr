<?php
use Toiee\haik\Plugins\Slide\SlidePlugin;

class SlidePluginTest extends TestCase {

    public function testConvertMethodExists()
    {
        $this->assertInternalType('string', with(new SlidePlugin)->convert());
    }

    public function testSlideWithNoParams()
    {
        // !TODO: use for combined test
        $this->markTestIncomplete();

        # This is the test of slide with body has just one line.
        $slide_obj = new SlidePlugin();
        $id = $slide_obj->getId();

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

        $body = "![alt](http://placehold.jp/1000x400.png)\n"
              . "#### test title\n"
              . "test\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($one_line['assert']));
        $actual_return = $slide_obj->convert($one_line['slide'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);


        # This is the test of slide with body has some lines.
        $slide_obj = new SlidePlugin();
        $id = $slide_obj->getId();

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

        $body = "![alt](http://placehold.jp/1000x400.png)\n"
              . "#### test title\n"
              . "test\n"
              . "====\n"
              . "![alt](http://placehold.jp/1000x400.png)\n"
              . "#### test title\n"
              . "test\n"
              . "====\n"
              . "![alt](http://placehold.jp/1000x400.png)\n"
              . "#### test title\n"
              . "test\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($some_lines['assert']));
        $actual_return = $slide_obj->convert($some_lines['slide'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);




        # This is the test of slide with body that one is no title, anoter is no caption, another is both none.
        $slide_obj = new SlidePlugin();
        $id = $slide_obj->getId();

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


    public function testEmptyItem()
    {
        $body = '';
        $expected = array();

        $slide_obj = new SlidePlugin();
        $result = $slide_obj->convert(array(), $body);
        
        $this->assertAttributeEquals($expected, 'items', $slide_obj);


        $body = "====\n====\n";
        $expected = array();

        $slide_obj = new SlidePlugin();
        $result = $slide_obj->convert(array(), $body);
        
        $this->assertAttributeEquals($expected, 'items', $slide_obj);
    }

    public function testFullItem()
    {
        $body = '![alt](http://placehold.jp/1000x400.png)' . "\n"
              . '### Third Slide' . "\n"
              . 'This is first slide.';
        $expected = array(array(
            'image' => '<img src="http://placehold.jp/1000x400.png" alt="alt">',
            'heading' => '<h3>Third Slide</h3>',
            'body' => '<p>This is first slide.</p>',
        ));

        $slide_obj = new SlidePlugin();
        $result = $slide_obj->convert(array(), $body);
        
        $this->assertAttributeEquals($expected, 'items', $slide_obj);
    }

    public function testOnlyImage()
    {
        $body = '![alt](http://placehold.jp/1000x400.png)';
        $expected = array(array(
            'image' => '<img src="http://placehold.jp/1000x400.png" alt="alt">',
            'body'  => '',
        ));

        $slide_obj = new SlidePlugin();
        $result = $slide_obj->convert(array(), $body);
        
        $this->assertAttributeEquals($expected, 'items', $slide_obj);
    }

    public function testOnlyBody()
    {
        $body = 'This is first slide.';
        $expected = array(array(
            'body' => '<p>This is first slide.</p>',
        ));

        $slide_obj = new SlidePlugin();
        $result = $slide_obj->convert(array(), $body);
        
        $this->assertAttributeEquals($expected, 'items', $slide_obj);
    }

    public function testOnlyHeading()
    {
        $body = '### Third Slide';
        $expected = array(array(
            'heading' => '<h3>Third Slide</h3>',
            'body'  => '',
        ));

        $slide_obj = new SlidePlugin();
        $result = $slide_obj->convert(array(), $body);
        
        $this->assertAttributeEquals($expected, 'items', $slide_obj);
    }

    public function testHeadingAndBody()
    {
        $body = '### Third Slide' . "\n"
              . 'This is first slide.';
        $expected = array(array(
            'heading' => '<h3>Third Slide</h3>',
            'body' => '<p>This is first slide.</p>',
        ));

        $slide_obj = new SlidePlugin();
        $result = $slide_obj->convert(array(), $body);
        
        $this->assertAttributeEquals($expected, 'items', $slide_obj);        
    }
    
    public function testImageAndBody()
    {
        $body = '![alt](http://placehold.jp/1000x400.png)' . "\n"
              . 'This is first slide.';
        $expected = array(array(
            'image' => '<img src="http://placehold.jp/1000x400.png" alt="alt">',
            'body' => '<p>This is first slide.</p>',
        ));

        $slide_obj = new SlidePlugin();
        $result = $slide_obj->convert(array(), $body);
        
        $this->assertAttributeEquals($expected, 'items', $slide_obj);
    }
    
    public function testImageAndHeading()
    {
        $body = '![alt](http://placehold.jp/1000x400.png)' . "\n"
              . '### Third Slide';
        $expected = array(array(
            'image' => '<img src="http://placehold.jp/1000x400.png" alt="alt">',
            'heading' => '<h3>Third Slide</h3>',
            'body'  => '',
        ));

        $slide_obj = new SlidePlugin();
        $result = $slide_obj->convert(array(), $body);
        
        $this->assertAttributeEquals($expected, 'items', $slide_obj);        
    }

    public function testWithNoButton()
    {
        $slide_obj = new SlidePlugin();
        $body = '![alt](http://placehold.jp/1000x400.png)'
              . '### Heading'
              . 'Body';

        $params = array('nobutton');
        $expected = array(
            'indicatorsSet' => false,
            'controlsSet'   => false,
            'wrapperOpen'   => '',
            'wrapperClose'  => '',
        );
        $slide_obj->convert($params, $body);
        
        $this->assertAttributeEquals($expected, 'options', $slide_obj);
    }

    public function testWithNoIndicator()
    {
        $slide_obj = new SlidePlugin();
        $body = '![alt](http://placehold.jp/1000x400.png)'
              . '### Heading'
              . 'Body';

        $params = array('noindicator');
        $expected = array(
            'indicatorsSet' => false,
            'controlsSet'   => true,
            'wrapperOpen'   => '',
            'wrapperClose'  => '',
        );
        $slide_obj->convert($params, $body);
        
        $this->assertAttributeEquals($expected, 'options', $slide_obj);
    }

    public function testWithNoControls()
    {
        $slide_obj = new SlidePlugin();
        $body = '![alt](http://placehold.jp/1000x400.png)'
              . '### Heading'
              . 'Body';

        $params = array('noslidebutton');
        $expected = array(
            'indicatorsSet' => true,
            'controlsSet'   => false,
            'wrapperOpen'   => '',
            'wrapperClose'  => '',
        );
        $slide_obj->convert($params, $body);
        
        $this->assertAttributeEquals($expected, 'options', $slide_obj);
    }

    public function testSlideWithParamsForButtons()
    {
        $this->markTestIncomplete();

        # This is the test of slide with nobutton param.
        $slide_obj = new SlidePlugin();
        $id = $slide_obj->getId();

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
        $id = $slide_obj->getId();

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
        $id = $slide_obj->getId();

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
        $id = $slide_obj->getId();

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
