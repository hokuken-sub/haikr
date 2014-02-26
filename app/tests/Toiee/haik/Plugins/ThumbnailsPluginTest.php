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
/*
            'nodelimiter' => array(
                'cols' => array('3+2','4+1.starbucks','class=tea'),
                'body' => "STYLE:background-color:#000;color:#ccc;\n".
                          "CLASS:burbon\n".
                          "col1\n".
                          "\n====\n".
                          "STYLE:background-color:#f33;color:#222;\n".
                          "CLASS:cafe\n".
                          "col2\n".
                          "col3",
                'assert' => '<div class="haik-plugin-thumbnails row tea">'."\n".
                            '<div class="col-sm-3 col-sm-offset-2 burbon" style="background-color:#000;color:#ccc;">'.\Parser::parse("col1").'</div>'."\n".
                            '<div class="col-sm-4 col-sm-offset-1 starbucks cafe" style="background-color:#f33;color:#222;">'.\Parser::parse("col2\ncol3").'</div>'."\n".
                            '</div>',
            ),
            'diffColsOverBody' => array(
                'cols' => array(6,6),
                'body' => "col1\n".
                          "\n====\n".
                          "col2\n".
                          "\n====\n".
                          "col3",
                'assert' => '<div class="haik-plugin-thumbnails row">'."\n".
                            '<div class="col-sm-6" style="">'.\Parser::parse("col1").'</div>'."\n".
                            '<div class="col-sm-6" style="">'.\Parser::parse("col2\n\n====\ncol3").'</div>'."\n".
                            '</div>',
            ),
            'diffColsLessBody' => array(
                'cols' => array(4,4,4),
                'body' => "col1\n".
                          "\n====\n".
                          "col2",
                'assert' => '<div class="haik-plugin-thumbnails row">'."\n".
                            '<div class="col-sm-4" style="">'.\Parser::parse("col1").'</div>'."\n".
                            '<div class="col-sm-4" style="">'.\Parser::parse("col2").'</div>'."\n".
                            '<div class="col-sm-4" style="">'."\n".'</div>'."\n".
                            '</div>',
            ),
*/
        );

        foreach ($tests as $key => $data)
        {
            $this->assertEquals($data['assert'], with(new ThumbnailsPlugin)->convert($data['cols'], $data['body']));
        }
    }


}