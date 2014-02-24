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
        $title_online = array(
            'panel' => array(),
            'assert' => '<div class="haik-plugin-panel panel panel-default">'
                      . '<div class="panel-heading">'.\Parser::parse('test title').'</div>'
                      . '<div class="panel-body">'.\Parser::parse('test').'</div></div>',
        );
        $this->assertEquals($title_online['assert'],
                            with(new PanelPlugin)->convert($title_online['panel'], "test title\n====\ntest"));


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

        $this->markTestIncomplete(
            'This test is Incomplete.'
        );
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

        $this->markTestIncomplete(
            'This test is Incomplete.'
        );
    }
}