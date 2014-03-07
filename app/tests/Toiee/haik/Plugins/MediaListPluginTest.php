<?php
use Toiee\haik\Plugins\MediaList\MediaListPlugin;

class MediaListPluginTest extends TestCase {

    public function testConvertMethodExists()
    {
        $this->assertInternalType('string', with(new MediaListPlugin)->convert());
    }

    public function testOneMediaListWithMarkdownImage()
    {
        $this->markTestIncomplete();
        # This is the test of left image, heading, body set.
        $test = array(
            'medialist' => array(),
            'assert' => '<div class="haik-plugin-medialist media">'."\n"
                      . '<span class="pull-left">'
                      . '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">'."\n"
                      . '</span>'."\n"
                      . '<div class="media-body">'."\n"
                      . '<h4 class="media-heading">test title</h4>'."\n"
                      . '<p>test</p>'."\n"
                      . '</div></div>',
        );

        $body = "![alt](http://placehold.jp/80x80.png)\n"
              . "#### test title\n"
              . "test\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($test['assert']));
        $actual_return = with(new MediaListPlugin)->convert($test['medialist'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);


        # This is the test of left DUMMY image, heading, body set.
        $test = array(
            'medialist' => array(),
            'assert' => '<div class="haik-plugin-medialist media">'."\n"
                      . '<span class="pull-left">'."\n"
                      . '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">'."\n"
                      . '</span>'."\n"
                      . '<div class="media-body">'."\n"
                      . '<h4 class="media-heading">test title</h4>'."\n"
                      . '<p>test</p>'."\n"
                      . '</div></div>'."\n",
        );

        $body = "#### test title\n"
              . "test\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($test['assert']));
        $actual_return = with(new MediaListPlugin)->convert($test['medialist'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);



        # This is the test of left DUMMY image and body set.
        $test = array(
            'medialist' => array(),
            'assert' => '<div class="haik-plugin-medialist media">'."\n"
                      . '<span class="pull-left">'."\n"
                      . '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">'."\n"
                      . '</span>'."\n"
                      . '<div class="media-body">'."\n"
                      . '<p>test</p>'."\n"
                      . '</div></div>',
        );

        $body = "test\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($test['assert']));
        $actual_return = with(new MediaListPlugin)->convert($test['medialist'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);



        # This is the test of left image, body set.
        $test = array(
            'medialist' => array(),
            'assert' => '<div class="haik-plugin-medialist media">'
                      . '<span class="pull-left">'
                      . '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">'
                      . '</span>'
                      . '<div class="media-body">'
                      . '<p>test</p>'
                      . '</div></div>',
        );

        $body = "![alt](http://placehold.jp/80x80.png)\n"
              . "test\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($test['assert']));
        $actual_return = with(new MediaListPlugin)->convert($test['medialist'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);



        # This is the test of right image, heading, body set.
        $test = array(
            'medialist' => array(),
            'assert' => '<div class="haik-plugin-medialist media">'."\n"
                      . '<span class="pull-right">'."\n"
                      . '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">'."\n"
                      . '</span>'."\n"
                      . '<div class="media-body">'."\n"
                      . '<h4 class="media-heading">test title</h4>'."\n"
                      . '<p>test</p>'."\n"
                      . '</div></div>',
        );

        $body = "#### test title\n"
              ."test\n"
              . "![alt](http://placehold.jp/80x80.png)\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($test['assert']));
        $actual_return = with(new MediaListPlugin)->convert($test['medialist'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);


        # This is the test of left image, heading, body set with many breaks between each.
        $test = array(
            'medialist' => array(),
            'assert' => '<div class="haik-plugin-medialist media">'."\n"
                      . '<span class="pull-left">'."\n"
                      . '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">'."\n"
                      . '</span>'."\n"
                      . '<div class="media-body">'."\n"
                      . '<h4 class="media-heading">test title</h4>'."\n"
                      . '<p>test</p>'."\n"
                      . '</div></div>',
        );

        $body = "\n\n\n"
              . "![alt](http://placehold.jp/80x80.png)\n"
              . "\n\n"
              . "#### test title\n"
              . "\n\n\n"
              . "test\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($test['assert']));
        $actual_return = with(new MediaListPlugin)->convert($test['medialist'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);


        # This is the test of left image, heading, some lines body set.
        $test = array(
            'medialist' => array(),
            'assert' => '<div class="haik-plugin-medialist media">'."\n"
                      . '<span class="pull-left">'."\n"
                      . '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">'."\n"
                      . '</span>'."\n"
                      . '<div class="media-body">'."\n"
                      . '<h4 class="media-heading">test title</h4>'."\n"
                      . "<p>test\ntest\ntest</p>"."\n"
                      . '</div></div>',
        );

        $body = "![alt](http://placehold.jp/80x80.png)\n"
              . "#### test title\n"
              . "test\n"
              . "test\n"
              . "test\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($test['assert']));
        $actual_return = with(new MediaListPlugin)->convert($test['medialist'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);


        # This is the test of left image, heading, some lines body with break set.
        $test = array(
            'medialist' => array(),
            'assert' => '<div class="haik-plugin-medialist media">'."\n"
                      . '<span class="pull-left">'."\n"
                      . '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">'."\n"
                      . '</span>'."\n"
                      . '<div class="media-body">'."\n"
                      . '<h4 class="media-heading">test title</h4>'."\n"
                      . "<p>test<br>\ntest\ntest</p>"."\n"
                      . '</div></div>',
        );

        $body = "![alt](http://placehold.jp/80x80.png)\n"
              . "#### test title\n"
              . "test  \n"
              . "test\n"
              . "test\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($test['assert']));
        $actual_return = with(new MediaListPlugin)->convert($test['medialist'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);


        # This is the test of medialists body contains same <img> of img.media-object
        $test = array(
            'medialist' => array(),
            'assert' => '<div class="haik-plugin-medialist media">'."\n"
                      . '<span class="pull-left">'."\n"
                      . '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">'."\n"
                      . '</span>'."\n"
                      . '<div class="media-body">'."\n"
                      . '<h4 class="media-heading">test title</h4>'."\n"
                      . '<p>test'."\n".'<img src="http://placehold.jp/80x80.png" alt="alt"></p>'."\n"
                      . '</div></div>',
        );

        $body = "![alt](http://placehold.jp/80x80.png)\n"
              . "#### test title\n"
              . "test\n"
              . "![alt](http://placehold.jp/80x80.png)\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($test['assert']));
        $actual_return = with(new MediaListPlugin)->convert($test['medialist'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);
        
        # This is the test of medialists only body contains heading
        $test = array(
            'medialist' => array(),
            'assert' => '<div class="haik-plugin-medialist media">'."\n"
                      . '<span class="pull-left">'."\n"
                      . '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">'."\n"
                      . '</span>'."\n"
                      . '<div class="media-body">'."\n"
                      . '<p>test</p>'."\n"
                      . '<h4>test title</h4>'."\n"
                      . '</div></div>',
        );

        $body = "![alt](http://placehold.jp/80x80.png)\n"
              . "test\n"
              . "#### test title\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($test['assert']));
        $actual_return = with(new MediaListPlugin)->convert($test['medialist'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);
        
        # This is the test of medialists order by heading heading body
        $test = array(
            'medialist' => array(),
            'assert' => '<div class="haik-plugin-medialist media">'."\n"
                      . '<span class="pull-left">'."\n"
                      . '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">'."\n"
                      . '</span>'."\n"
                      . '<div class="media-body">'."\n"
                      . '<h4 class="media-heading">test title</h4>'."\n"
                      . '<h4>test title</h4>'."\n"
                      . '<p>test</p>'."\n"
                      . '</div></div>',
        );

        $body = "#### test title\n"
              . "#### test title\n"
              . "test\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($test['assert']));
        $actual_return = with(new MediaListPlugin)->convert($test['medialist'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);

        # This is the test of medialists order by heading heading image
        $test = array(
            'medialist' => array(),
            'assert' => '<div class="haik-plugin-medialist media">'."\n"
                      . '<span class="pull-right">'."\n"
                      . '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">'."\n"
                      . '</span>'."\n"
                      . '<div class="media-body">'."\n"
                      . '<h4 class="media-heading">test title</h4>'."\n"
                      . '<h4>test title</h4>'."\n"
                      . '</div></div>',
        );

        $body = "#### test title\n"
              . "#### test title\n"
              . "![alt](http://placehold.jp/80x80.png)\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($test['assert']));
        $actual_return = with(new MediaListPlugin)->convert($test['medialist'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);

        # This is the test of medialists order by heading image heading
        $test = array(
            'medialist' => array(),
            'assert' => '<div class="haik-plugin-medialist media">'."\n"
                      . '<span class="pull-left">'."\n"
                      . '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">'."\n"
                      . '</span>'."\n"
                      . '<div class="media-body">'."\n"
                      . '<h4 class="media-heading">test title</h4>'."\n"
                      . '<p><img src="http://placehold.jp/80x80.png" alt="alt"></p>'."\n"
                      . '<h4>test title</h4>'."\n"
                      . '</div></div>',
        );

        $body = "#### test title\n"
              . "![alt](http://placehold.jp/80x80.png)\n"
              . "#### test title\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($test['assert']));
        $actual_return = with(new MediaListPlugin)->convert($test['medialist'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);

        # This is the test of medialists order by body image heading
        $test = array(
            'medialist' => array(),
            'assert' => '<div class="haik-plugin-medialist media">'."\n"
                      . '<span class="pull-left">'."\n"
                      . '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">'."\n"
                      . '</span>'."\n"
                      . '<div class="media-body">'."\n"
                      . '<p>test'."\n"
                      . '<img src="http://placehold.jp/80x80.png" alt="alt"></p>'."\n"
                      . '<h4>test title</h4>'."\n"
                      . '</div></div>',
        );

        $body = "test\n"
              . "![alt](http://placehold.jp/80x80.png)\n"
              . "#### test title\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($test['assert']));
        $actual_return = with(new MediaListPlugin)->convert($test['medialist'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);

        # This is the test of medialists order by body head image
        $test = array(
            'medialist' => array(),
            'assert' => '<div class="haik-plugin-medialist media">'."\n"
                      . '<span class="pull-right">'."\n"
                      . '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">'."\n"
                      . '</span>'."\n"
                      . '<div class="media-body">'."\n"
                      . '<p>test</p>'."\n"
                      . '<h4>test title</h4>'."\n"
                      . '</div></div>',
        );

        $body = "test\n"
              . "#### test title\n"
              . "![alt](http://placehold.jp/80x80.png)\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($test['assert']));
        $actual_return = with(new MediaListPlugin)->convert($test['medialist'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);

        # This is the test of medialists order by image body image
        $test = array(
            'medialist' => array(),
            'assert' => '<div class="haik-plugin-medialist media">'."\n"
                      . '<span class="pull-left">'."\n"
                      . '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">'."\n"
                      . '</span>'."\n"
                      . '<div class="media-body">'."\n"
                      . '<p>test'."\n"
                      . '<img src="http://placehold.jp/80x80.png" alt="alt"></p>'."\n"
                      . '</div></div>',
        );

        $body = "![alt](http://placehold.jp/80x80.png)\n"
              . "test\n"
              . "![alt](http://placehold.jp/80x80.png)\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($test['assert']));
        $actual_return = with(new MediaListPlugin)->convert($test['medialist'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);
    }

    public function testMoreThanTwoMediaListWithMarkdownImage()
    {
        $this->markTestIncomplete();

        $assert = '<div class="haik-plugin-medialist media">'."\n"
                . '<span class="pull-left">'."\n"
                . '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">'."\n"
                . '</span>'."\n"
                . '<div class="media-body">'."\n"
                . '<h4 class="media-heading">test title</h4>'."\n"
                . '<p>test</p>'."\n"
                . '</div></div>';


        # This is the test of TWO medialists with left image, heading, body set.
        $test = array(
            'medialist' => array(),
            'assert' => $assert."\n".$assert,
        );

        $body = "![alt](http://placehold.jp/80x80.png)\n"
              . "#### test title\n"
              . "test\n"
              . "====\n"
              . "![alt](http://placehold.jp/80x80.png)\n"
              . "#### test title\n"
              . "test\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($test['assert']));
        $actual_return = with(new MediaListPlugin)->convert($test['medialist'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);

        # This is the test of THREE medialists with left image, heading, body set.
        $test = array(
            'medialist' => array(),
            'assert' => $assert."\n".$assert."\n".$assert,
        );

        $body = "![alt](http://placehold.jp/80x80.png)\n"
              . "#### test title\n"
              . "test\n"
              . "====\n"
              . "![alt](http://placehold.jp/80x80.png)\n"
              . "#### test title\n"
              . "test\n"
              . "====\n"
              . "![alt](http://placehold.jp/80x80.png)\n"
              . "#### test title\n"
              . "test\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($test['assert']));
        $actual_return = with(new MediaListPlugin)->convert($test['medialist'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);
    }

    public function testMediaListWithColumn()
    {
        $this->markTestIncomplete();

        $main = '<div class="haik-plugin-medialist media">'."\n"
                . '<span class="pull-left">'."\n"
                . '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">'."\n"
                . '</span>'."\n"
                . '<div class="media-body">'."\n"
                . '<h4 class="media-heading">test title</h4>'."\n"
                . '<p>test</p>'."\n"
                . '</div></div>';

        # This is the test of medialists with param only cols.
        $start_tag = '<div class="row"><div class="col-sm-6">';
        $close_tag = '</div></div>';
        $test = array(
            'medialist' => array('6'),
            'assert' => $start_tag.$main.$close_tag,
        );

        $body = "![alt](http://placehold.jp/80x80.png)\n"
              . "#### test title\n"
              . "test\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($test['assert']));
        $actual_return = with(new MediaListPlugin)->convert($test['medialist'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);


        # This is the test of medialists with param cols & offset.
        $start_tag = '<div class="row"><div class="col-sm-5 col-sm-offset-1">';
        $close_tag = '</div></div>';
        $test = array(
            'medialist' => array('5+1'),
            'assert' => $start_tag.$main.$close_tag,
        );

        $body = "![alt](http://placehold.jp/80x80.png)\n"
              . "#### test title\n"
              . "test\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($test['assert']));
        $actual_return = with(new MediaListPlugin)->convert($test['medialist'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);


        # This is the test of medialists with param cols & class.
        $start_tag = '<div class="row"><div class="col-sm-6 well">';
        $close_tag = '</div></div>';
        $test = array(
            'medialist' => array('6.well'),
            'assert' => $start_tag.$main.$close_tag,
        );

        $body = "![alt](http://placehold.jp/80x80.png)\n"
              . "#### test title\n"
              . "test\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($test['assert']));
        $actual_return = with(new MediaListPlugin)->convert($test['medialist'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);


        # This is the test of medialists with param cols & offset & class.
        $start_tag = '<div class="row"><div class="col-sm-5 col-sm-offset-1 well">';
        $close_tag = '</div></div>';
        $test = array(
            'medialist' => array('5+1.well'),
            'assert' => $start_tag.$main.$close_tag,
        );

        $body = "![alt](http://placehold.jp/80x80.png)\n"
              . "#### test title\n"
              . "test\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($test['assert']));
        $actual_return = with(new MediaListPlugin)->convert($test['medialist'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);


        # This is the test of medialists with param cols & offset & double class.
        $start_tag = '<div class="row"><div class="col-sm-5 col-sm-offset-1 panel panel-default">';
        $close_tag = '</div></div>';
        $test = array(
            'medialist' => array('5+1.panel.panel-default'),
            'assert' => $start_tag.$main.$close_tag,
        );

        $body = "![alt](http://placehold.jp/80x80.png)\n"
              . "#### test title\n"
              . "test\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($test['assert']));
        $actual_return = with(new MediaListPlugin)->convert($test['medialist'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);


        # This is the test of multi medialists with param cols & offset & double class.
        $start_tag = '<div class="row"><div class="col-sm-5 col-sm-offset-1 panel panel-default">';
        $close_tag = '</div></div>';
        $test = array(
            'medialist' => array('5+1.panel.panel-default'),
            'assert' => $start_tag.$main."\n".$main.$close_tag,
        );

        $body = "![alt](http://placehold.jp/80x80.png)\n"
              . "#### test title\n"
              . "test\n"
              . "====\n"
              . "![alt](http://placehold.jp/80x80.png)\n"
              . "#### test title\n"
              . "test\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($test['assert']));
        $actual_return = with(new MediaListPlugin)->convert($test['medialist'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);
    }

    public function testEscapeParameter()
    {
        $this->markTestIncomplete();

        $main = '<div class="haik-plugin-medialist media">'."\n"
                . '<span class="pull-left">'."\n"
                . '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">'."\n"
                . '</span>'."\n"
                . '<div class="media-body">'."\n"
                . '<h4 class="media-heading">test title</h4>'."\n"
                . '<p>test</p>'."\n"
                . '</div></div>';

        # This is the test of medialists with param cols & offset & double class.
        $start_tag = '<div class="row"><div class="">';
        $close_tag = '</div></div>';
        $test = array(
            'medialist' => array('6.<hogehoge>'),
            'assert' => $start_tag.$main.$close_tag,
        );

        $body = "![alt](http://placehold.jp/80x80.png)\n"
              . "#### test title\n"
              . "test\n";

        $expect_return = preg_replace('/\n| {2,}/', '', trim($test['assert']));
        $actual_return = with(new MediaListPlugin)->convert($test['medialist'], $body);
        $actual_return = preg_replace('/\n| {2,}/', '', trim($actual_return));

        $this->assertEquals($expect_return, $actual_return);
    }
}