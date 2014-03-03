<?php
use Toiee\haik\Plugins\Panel\PanelPlugin;

class PanelPluginTest extends TestCase {

    public function testConvertMethodExists()
    {
        $this->assertInternalType('string', with(new PanelPlugin)->convert());
    }

    /**
     * @dataProvider paramsProvider
     */
    public function testParameterNoHeading($panel, $assert)
    {
        # create mock to return same content.
        App::bind('ParserInterface', function()
        {
            $mock = Mockery::mock('Toiee\haik\Providers\ParserInterface');
            $mock->shouldReceive('parse')->andReturn('<p>test</p>');
            return $mock;
        });

        $this->assertEquals($assert, with(new PanelPlugin)->convert($panel, 'test'));
    }
    
    public function paramsProvider()
    {
        return array(
            array(
                array(),
                '<div class="haik-plugin-panel panel panel-default">'
              . '<div class="panel-body"><p>test</p></div></div>',
            ),
            array(
                array('primary'),
                '<div class="haik-plugin-panel panel panel-primary">'
               . '<div class="panel-body"><p>test</p></div></div>',
            ),
        );
    }


    public function testParameterWithHeading()
    {
        # test $body has only one line.
        $title_online = array(
            'panel' => array(),
            'assert' => '<div class="haik-plugin-panel panel panel-default">'
                      . '<div class="panel-heading">'.\Parser::parse('test title').'</div>'
                      . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
        );
        $this->assertEquals($title_online['assert'],
                            with(new PanelPlugin)->convert($title_online['panel'], "test title\n====\ntest"));


        # test $body has many break line.
        $title_multiline = array(
            'panel' => array('primary'),
            'assert' => '<div class="haik-plugin-panel panel panel-primary">'
                      . '<div class="panel-heading">'.\Parser::parse('test title').'</div>'
                      . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
        );
        $this->assertEquals($title_multiline['assert'],
                            with(new PanelPlugin)->convert($title_multiline['panel'], "test title\n\n\n====\n\n\ntest"));
    }


    public function testHeadingParse()
    {
        # test $body is markdown case for 6 times(heading num is increase 1 by 1).
        for ($i = 1; $i <= 6; $i++)
        {
            $md_heading = array(
                'panel' => array(),
                'assert' => '<div class="haik-plugin-panel panel panel-default">'
                          . '<div class="panel-heading">'
                          . '<h'.strval($i).' class="panel-title">test title</h'.strval($i).'>'."\n".'</div>'
                          . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
            );
            $this->assertEquals($md_heading['assert'],
                                with(new PanelPlugin)->convert($md_heading['panel'], str_repeat('#', $i)." test title\n====\ntest"));
        }

        # test $body is html case for 6 times(heading num is increase 1 by 1).
        for ($i = 1; $i <= 6; $i++)
        {
            $html_heading = array(
                'panel' => array(),
                'assert' => '<div class="haik-plugin-panel panel panel-default">'
                          . '<div class="panel-heading">'
                          . '<h'.strval($i).' class="panel-title">test title</h'.strval($i).'>'."\n".'</div>'
                          . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
            );
            $this->assertEquals($html_heading['assert'],
                                with(new PanelPlugin)->convert($html_heading['panel'], "<h".strval($i).">test title</h".strval($i).">\n====\ntest"));
        }
    }


    public function testMultipleHeadingParse()
    {
        # test $body is markdown case for 6 times(heading num & line are increase 1 by 1).
        for ($i = 1; $i <= 6; $i++)
        {
            $html = str_repeat('<h'.strval($i).' class="panel-title">test title</h'.strval($i).'>', $i);

            $md_heading = array(
                'panel' => array(),
                'assert' => '<div class="haik-plugin-panel panel panel-default">'
                          . '<div class="panel-heading">'
                          . \Parser::parse($html).'</div>'
                          . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
            );

            $body = str_repeat(str_repeat('#', $i)." test title\n", $i)."====\ntest";
            $this->assertEquals($md_heading['assert'],
                                with(new PanelPlugin)->convert($md_heading['panel'], $body));
        }

        # test $body is html case for 6 times(heading num & line are increase 1 by 1).
        for ($i = 1; $i <= 6; $i++)
        {
            $html = str_repeat('<h'.strval($i).' class="panel-title">test title</h'.strval($i).'>', $i);

            $html_heading = array(
                'panel' => array(),
                'assert' => '<div class="haik-plugin-panel panel panel-default">'
                          . '<div class="panel-heading">'
                          . \Parser::parse($html).'</div>'
                          . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
            );

            $body = str_repeat("<h".strval($i).">test title</h".strval($i).">\n", $i)."====\ntest";
            $this->assertEquals($html_heading['assert'],
                                with(new PanelPlugin)->convert($html_heading['panel'], $body));
        }
    }

    public function testHeadingWithSomeClass()
    {
            # return is always with panel-title class when user didn't put custom class.
            $return = "# test title {.panel-title}\n"
                    . "# test title {.panel-title}\n"
                    . "# test title {.panel-title}\n";

            # test $body is markdown case.
            $md_heading = array(
                'panel' => array(),
                'assert' => '<div class="haik-plugin-panel panel panel-default">'
                          . '<div class="panel-heading">'
                          . \Parser::parse($return).'</div>'
                          . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
            );

            $body = "# test title {.panel-title}\n"
                  . "# test title\n"
                  . "# test title\n====\ntest";
            $this->assertEquals($md_heading['assert'],
                                with(new PanelPlugin)->convert($md_heading['panel'], $body));

            $body = "# test title\n"
                  . "# test title {.panel-title}\n"
                  . "# test title {.panel-title}\n====\ntest";
            $this->assertEquals($md_heading['assert'],
                                with(new PanelPlugin)->convert($md_heading['panel'], $body));

            # test $body is html case.
            $html_heading = array(
                'panel' => array(),
                'assert' => '<div class="haik-plugin-panel panel panel-default">'
                          . '<div class="panel-heading">'
                          . \Parser::parse($return).'</div>'
                          . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
            );

            $body = "<h1 class=\"panel-title\">test title</h1>\n"
                  . "<h1>test title</h1>\n"
                  . "<h1>test title</h1>\n====\ntest";
            $this->assertEquals($html_heading['assert'],
                                with(new PanelPlugin)->convert($html_heading['panel'], $body));
    }

    public function testHeadingWithCustomClass()
    {
        # test $body is markdown case.
        $md_heading = array(
            'panel' => array(),
            'assert' => '<div class="haik-plugin-panel panel panel-default">'
                      . '<div class="panel-heading">'
                      . \Parser::parse('# test title {.custom-class}').'</div>'
                      . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
        );
        $this->assertEquals($md_heading['assert'],
                            with(new PanelPlugin)->convert($md_heading['panel'], "# test title {.custom-class}\n====\ntest"));

        # test $body is html case.
        $html_heading = array(
            'panel' => array(),
            'assert' => '<div class="haik-plugin-panel panel panel-default">'
                      . '<div class="panel-heading">'
                      . \Parser::parse('<h1 class="custom-class">test title</h1>').'</div>'
                      . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
        );
        $this->assertEquals($html_heading['assert'],
                            with(new PanelPlugin)->convert($html_heading['panel'],
                                                           "<h1 class=\"custom-class\">test title</h1>\n====\ntest"));
    }

    public function testHeadingWithCustomData()
    {
        # test $body has only custom data.
        $html_heading = array(
            'panel' => array(),
            'assert' => '<div class="haik-plugin-panel panel panel-default">'
                      . '<div class="panel-heading">'
                      . \Parser::parse('<h1 data-hoge="hoge" class="panel-title">test title</h1>').'</div>'
                      . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
        );
        $this->assertEquals($html_heading['assert'],
                            with(new PanelPlugin)->convert($html_heading['panel'],
                                                           "<h1 data-hoge=\"hoge\">test title</h1>\n====\ntest"));

        # test $body has custom data & custom class.
        $html_heading_with_class = array(
            'panel' => array(),
            'assert' => '<div class="haik-plugin-panel panel panel-default">'
                      . '<div class="panel-heading">'
                      . \Parser::parse('<h1 data-hoge="hoge" class="hogehoge">test title</h1>').'</div>'
                      . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
        );
        $this->assertEquals($html_heading_with_class['assert'],
                            with(new PanelPlugin)->convert($html_heading_with_class['panel'],
                                                           "<h1 data-hoge=\"hoge\" class=\"hogehoge\">test title</h1>\n====\ntest"));
    }

    public function testParseHeadingAndElse()
    {
        $return = "# test title {.panel-title}\n"
                . "test\n"
                . "# test title {.panel-title}\n";

        # test $body is markdown case.
        $md_heading = array(
            'panel' => array(),
            'assert' => '<div class="haik-plugin-panel panel panel-default">'
                      . '<div class="panel-heading">'
                      . \Parser::parse($return).'</div>'
                      . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
        );

        $body = "# test title\n"
              . "test\n"
              . "# test title {.panel-title}\n====\ntest";
        $this->assertEquals($md_heading['assert'],
                            with(new PanelPlugin)->convert($md_heading['panel'], $body));

        # test $body is html case.
        $html_heading = array(
            'panel' => array(),
            'assert' => '<div class="haik-plugin-panel panel panel-default">'
                      . '<div class="panel-heading">'
                      . \Parser::parse($return).'</div>'
                      . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
        );

        $body = "<h1 class=\"panel-title\">test title</h1>\n"
              . "<p>test</p>\n"
              . "<h1>test title</h1>\n====\ntest";
        $this->assertEquals($html_heading['assert'],
                            with(new PanelPlugin)->convert($html_heading['panel'], $body));
    }

    public function testPanelWithColumn()
    {
        # This is the test of only column parameter
        $wrapper_open = '<div class="row"><div class="col-sm-6">';
        $wrapper_close = '</div></div>';

        $with_column = array(
            'panel' => array('6'),
            'assert' => $wrapper_open
                      . '<div class="haik-plugin-panel panel panel-default">'
                      . '<div class="panel-heading">'
                      . '<h1 class="panel-title">test title</h1>'."\n".'</div>'
                      . '<div class="panel-body">'.\Parser::parse('test').'</div></div>'
                      . $wrapper_close,
        );

        $body = "# test title\n"
              . "====\n"
              . "test";
        $this->assertEquals($with_column['assert'],
                            with(new PanelPlugin)->convert($with_column['panel'], $body));


        # This is the test of panel with params order color, column.
        $wrapper_open = '<div class="row"><div class="col-sm-6">';
        $wrapper_close = '</div></div>';

        $with_column = array(
            'panel' => array('primary', '6'),
            'assert' => $wrapper_open
                      . '<div class="haik-plugin-panel panel panel-primary">'
                      . '<div class="panel-heading">'
                      . '<h1 class="panel-title">test title</h1>'."\n".'</div>'
                      . '<div class="panel-body">'.\Parser::parse('test').'</div></div>'
                      . $wrapper_close,
        );

        $body = "# test title\n"
              . "====\n"
              . "test";
        $this->assertEquals($with_column['assert'],
                            with(new PanelPlugin)->convert($with_column['panel'], $body));


        # This is the test of panel with params order column, color.
        $wrapper_open = '<div class="row"><div class="col-sm-6">';
        $wrapper_close = '</div></div>';

        $with_column = array(
            'panel' => array('6', 'primary'),
            'assert' => $wrapper_open
                      . '<div class="haik-plugin-panel panel panel-primary">'
                      . '<div class="panel-heading">'
                      . '<h1 class="panel-title">test title</h1>'."\n".'</div>'
                      . '<div class="panel-body">'.\Parser::parse('test').'</div></div>'
                      . $wrapper_close,
        );

        $body = "# test title\n"
              . "====\n"
              . "test";
        $this->assertEquals($with_column['assert'],
                            with(new PanelPlugin)->convert($with_column['panel'], $body));
    }
}