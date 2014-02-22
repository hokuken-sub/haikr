<?php
use Toiee\haik\Plugins\Panel\PanelPlugin;

class PanelPluginTest extends TestCase {

    public function testConvertMethodExists()
    {
        $this->assertInternalType('string', with(new PanelPlugin)->convert());
    }

    
    public function testParameterNoHeading()
    {
        $tests = array(
            'default' => array(
                'panel' => array(),
                'assert' => '<div class="haik-plugin-panel panel panel-default">'
                          . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
            ),
            'twbs_primary' => array(
                'panel' => array('primary'),
                'assert' => '<div class="haik-plugin-panel panel panel-primary">'
                          . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
            ),
            'twbs_success' => array(
                'panel' => array('success'),
                'assert' => '<div class="haik-plugin-panel panel panel-success">'
                          . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
            ),
            'twbs_info' => array(
                'panel' => array('info'),
                'assert' => '<div class="haik-plugin-panel panel panel-info">'
                          . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
            ),
            'twbs_warning' => array(
                'panel' => array('warning'),
                'assert' => '<div class="haik-plugin-panel panel panel-warning">'
                          . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
            ),
            'twbs_danger' => array(
                'panel' => array('danger'),
                'assert' => '<div class="haik-plugin-panel panel panel-danger">'
                          . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
            ),

        );

        foreach ($tests as $key => $data)
        {
            $this->assertEquals($data['assert'], with(new PanelPlugin)->convert($data['panel'], 'test'));
        }
    }


    public function testParameterWithHeading()
    {
        $tests = array(
            'default' => array(
                'panel' => array(),
                'assert' => '<div class="haik-plugin-panel panel panel-default">'
                          . '<div class="panel-heading">'.\Parser::parse('test title').'</div>'
                          . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
            ),
            'twbs_primary' => array(
                'panel' => array('primary'),
                'assert' => '<div class="haik-plugin-panel panel panel-primary">'
                          . '<div class="panel-heading">'.\Parser::parse('test title').'</div>'
                          . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
            ),
            'twbs_success' => array(
                'panel' => array('success'),
                'assert' => '<div class="haik-plugin-panel panel panel-success">'
                          . '<div class="panel-heading">'.\Parser::parse('test title').'</div>'
                          . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
            ),
            'twbs_info' => array(
                'panel' => array('info'),
                'assert' => '<div class="haik-plugin-panel panel panel-info">'
                          . '<div class="panel-heading">'.\Parser::parse('test title').'</div>'
                          . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
            ),
            'twbs_warning' => array(
                'panel' => array('warning'),
                'assert' => '<div class="haik-plugin-panel panel panel-warning">'
                          . '<div class="panel-heading">'.\Parser::parse('test title').'</div>'
                          . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
            ),
            'twbs_danger' => array(
                'panel' => array('danger'),
                'assert' => '<div class="haik-plugin-panel panel panel-danger">'
                          . '<div class="panel-heading">'.\Parser::parse('test title').'</div>'
                          . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
            ),

        );

        foreach ($tests as $key => $data)
        {
            $this->assertEquals($data['assert'], with(new PanelPlugin)->convert($data['panel'], "test title\n====\ntest"));
        }
    }


    public function testHeadingParse()
    {
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

        for ($i = 1; $i <= 6; $i++)
        {
            $directly_html_heading = array(
                'panel' => array(),
                'assert' => '<div class="haik-plugin-panel panel panel-default">'
                          . '<div class="panel-heading">'
                          . '<h'.strval($i).' class="panel-title">test title</h'.strval($i).'>'."\n".'</div>'
                          . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
            );
            $this->assertEquals($directly_html_heading['assert'],
                                with(new PanelPlugin)->convert($directly_html_heading['panel'],
                                                               "<h".strval($i)." class=\"panel-title\">test title</h".strval($i).">\n====\ntest"));
        }
    }


    public function testMultipleHeadingParse()
    {
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

        for ($i = 1; $i <= 6; $i++)
        {
            $html = str_repeat('<h'.strval($i).' class="panel-title">test title</h'.strval($i).'>', $i);

            $directly_html_heading = array(
                'panel' => array(),
                'assert' => '<div class="haik-plugin-panel panel panel-default">'
                          . '<div class="panel-heading">'
                          . \Parser::parse($html).'</div>'
                          . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
            );

            $body = str_repeat("<h".strval($i)." class=\"panel-title\">test title</h".strval($i).">", $i)."\n====\ntest";
            $this->assertEquals($directly_html_heading['assert'],
                                with(new PanelPlugin)->convert($directly_html_heading['panel'], $body));
        }


        $this->markTestIncomplete(
            'This test is Incomplete.'
        );
    }
}