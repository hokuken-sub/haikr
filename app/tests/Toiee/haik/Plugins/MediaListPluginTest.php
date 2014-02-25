<?php
use Toiee\haik\Plugins\MediaList\MediaListPlugin;

class MediaListPluginTest extends TestCase {

    public function testConvertMethodExists()
    {
        $this->assertInternalType('string', with(new MediaListPlugin)->convert());
    }

    public function testOneMediaListWithMarkdownImage()
    {
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

        $body = "![alt](http://placehold.jp/80x80.png)\n"."#### test title\n"."test\n";
        $this->assertEquals($test['assert'], with(new MediaListPlugin)->convert($test['medialist'], $body));


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

        $body = "#### test title\n"."test\n";
        $this->assertEquals($test['assert'], with(new MediaListPlugin)->convert($test['medialist'], $body));


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

        $body = "![alt](http://placehold.jp/80x80.png)\n"."test\n";
        $this->assertEquals($test['assert'], with(new MediaListPlugin)->convert($test['medialist'], $body));
    }
}