<?php
use Toiee\haik\Plugins\MediaList\MediaListPlugin;

class MediaListPluginTest extends TestCase {

    public function testConvertMethodExists()
    {
        $this->assertInternalType('string', with(new MediaListPlugin)->convert());
    }

    public function testOneMediaListWithMarkdownImage()
    {
        # This is the test of left image, heading, body set.
        $test = array(
            'medialist' => array(),
            'assert' => '<div class="media">'
                      . '<span class="pull-left">'
                      . '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">'
                      . '</span>'
                      . '<div class="media-body">'
                      . '<h4 class="media-heading">test title</h4>'
                      . '<p>test</p>'
                      . '</div></div>',
        );

        $body = "![alt](http://placehold.jp/80x80.png)\n"
              . "#### test title\n"
              . "test\n";

        $this->assertEquals($test['assert'], with(new MediaListPlugin)->convert($test['medialist'], $body));



        # This is the test of left DUMMY image, heading, body set.
        $test = array(
            'medialist' => array(),
            'assert' => '<div class="media">'
                      . '<span class="pull-left">'
                      . '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">'
                      . '</span>'
                      . '<div class="media-body">'
                      . '<h4 class="media-heading">test title</h4>'
                      . '<p>test</p>'
                      . '</div></div>',
        );

        $body = "#### test title\n"
              . "test\n";

        $this->assertEquals($test['assert'], with(new MediaListPlugin)->convert($test['medialist'], $body));



        # This is the test of left DUMMY image and body set.
        $test = array(
            'medialist' => array(),
            'assert' => '<div class="media">'
                      . '<span class="pull-left">'
                      . '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">'
                      . '</span>'
                      . '<div class="media-body">'
                      . '<p>test</p>'
                      . '</div></div>',
        );

        $body = "test\n";

        $this->assertEquals($test['assert'], with(new MediaListPlugin)->convert($test['medialist'], $body));



        # This is the test of left image, body set.
        $test = array(
            'medialist' => array(),
            'assert' => '<div class="media">'
                      . '<span class="pull-left">'
                      . '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">'
                      . '</span>'
                      . '<div class="media-body">'
                      . '<p>test</p>'
                      . '</div></div>',
        );

        $body = "![alt](http://placehold.jp/80x80.png)\n"
              . "test\n";

        $this->assertEquals($test['assert'], with(new MediaListPlugin)->convert($test['medialist'], $body));



        # This is the test of right image, heading, body set.
        $test = array(
            'medialist' => array(),
            'assert' => '<div class="media">'
                      . '<span class="pull-right">'
                      . '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">'
                      . '</span>'
                      . '<div class="media-body">'
                      . '<h4 class="media-heading">test title</h4>'
                      . '<p>test</p>'
                      . '</div></div>',
        );

        $body = "#### test title\n"."test\n"
              . "![alt](http://placehold.jp/80x80.png)\n";

        $this->assertEquals($test['assert'], with(new MediaListPlugin)->convert($test['medialist'], $body));



        # This is the test of left image, heading, body set with many breaks between each.
        $test = array(
            'medialist' => array(),
            'assert' => '<div class="media">'
                      . '<span class="pull-left">'
                      . '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">'
                      . '</span>'
                      . '<div class="media-body">'
                      . '<h4 class="media-heading">test title</h4>'
                      . '<p>test</p>'
                      . '</div></div>',
        );

        $body = "\n\n\n"
              . "![alt](http://placehold.jp/80x80.png)\n"
              . "\n\n"
              . "#### test title\n"
              . "\n\n\n"
              . "test\n";

        $this->assertEquals($test['assert'], with(new MediaListPlugin)->convert($test['medialist'], $body));
    }

    public function testMoreThanTwoMediaListWithMarkdownImage()
    {

        $assert = '<div class="media">'
                . '<span class="pull-left">'
                . '<img class="media-object" src="http://placehold.jp/80x80.png" alt="alt">'
                . '</span>'
                . '<div class="media-body">'
                . '<h4 class="media-heading">test title</h4>'
                . '<p>test</p>'
                . '</div></div>';


        # This is the test of TWO medialists with left image, heading, body set.
        $test = array(
            'medialist' => array(),
            'assert' => $assert.$assert,
        );

        $body = "![alt](http://placehold.jp/80x80.png)\n"
              . "#### test title\n"
              . "test\n"
              . "====\n"
              . "![alt](http://placehold.jp/80x80.png)\n"
              . "#### test title\n"
              . "test\n";

        $this->assertEquals($test['assert'], with(new MediaListPlugin)->convert($test['medialist'], $body));

        # This is the test of THREE medialists with left image, heading, body set.
        $test = array(
            'medialist' => array(),
            'assert' => $assert.$assert.$assert,
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

        $this->assertEquals($test['assert'], with(new MediaListPlugin)->convert($test['medialist'], $body));
    }
}