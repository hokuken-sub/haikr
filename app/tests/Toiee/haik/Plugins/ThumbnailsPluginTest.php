<?php
use Toiee\haik\Plugins\Thumbnails\ThumbnailsPlugin;


class ThumbnailsPluginTest extends TestCase {

    public function testConvertMethodExists()
    {
        $this->assertInternalType('string', with(new ThumbnailsPlugin)->convert());
    }

    public function testHtml()
    {
        $tests = array(
            'no_params' => array(
                'cols' => array(),
                'body' => 'test',
                'assert' => '<div class="haik-plugin-thumbnails row ">'."\n".
                            '  <div class="col-sm-12" style="">'."\n".
                            '    <div class="thumbnail">'."\n".
                            '      '."\n".
                            '      <div class="caption">'."\n".
                            '        '.\Parser::parse('test')."\n".
                            '      </div>'."\n".
                            '    </div>'."\n". 
                            '  </div>'."\n". 
                            '</div>',
            ),
            'one' => array(
                'cols' => array(),
                'body' => "STYLE:background-color:#000;color:#ccc;\n".
                          "CLASS:burbon\n".
                          '![text](http://pacehold.jp/150x150.png "title")'."\n".
                          "#thumbnail title\n".
                          "body1\n".
                          "body2",
                'assert' => '<div class="haik-plugin-thumbnails row ">'."\n".
                            '  <div class="col-sm-12 burbon" style="background-color:#000;color:#ccc;">'."\n".
                            '    <div class="thumbnail">'."\n".
                            '      <img src="http://pacehold.jp/150x150.png" alt="text" title="title">'."\n".
                            '      <div class="caption">'."\n".
                            '        '.\Parser::parse("#thumbnail title\nbody1\nbody2")."\n".
                            '      </div>'."\n".
                            '    </div>'."\n".
                            '  </div>'."\n".
                            '</div>',
            ),
            'two' => array(
                'cols' => array(),
                'body' => '![image1](http://pacehold.jp/120x200.png "title1")'."\n".
                          "#thumbnail title1\n".
                          "body1"."\n".
                          "====\n".
                          '![image2](http://pacehold.jp/140x200.png "title2")'."\n".
                          "#thumbnail title2\n".
                          "body2",
                'assert' => '<div class="haik-plugin-thumbnails row ">'."\n".
                            '  <div class="col-sm-6" style="">'."\n".
                            '    <div class="thumbnail">'."\n".
                            '      <img src="http://pacehold.jp/120x200.png" alt="image1" title="title1">'."\n".
                            '      <div class="caption">'."\n".
                            '        '.\Parser::parse("#thumbnail title1\nbody1")."\n".
                            '      </div>'."\n".
                            '    </div>'."\n".
                            '  </div>'."\n".
                            '  <div class="col-sm-6" style="">'."\n".
                            '    <div class="thumbnail">'."\n".
                            '      <img src="http://pacehold.jp/140x200.png" alt="image2" title="title2">'."\n".
                            '      <div class="caption">'."\n".
                            '        '.\Parser::parse("#thumbnail title2\nbody2")."\n".
                            '      </div>'."\n".
                            '    </div>'."\n".
                            '  </div>'."\n".
                            '</div>',
            ),
        );

        foreach ($tests as $key => $data)
        {
            $this->assertEquals($data['assert'], with(new ThumbnailsPlugin)->convert($data['cols'], $data['body']));
        }
    }


}