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
                          . '<div class="panel-body">test</div></div>',
            ),
            'twbs_primary' => array(
                'panel' => array('primary'),
                'assert' => '<div class="haik-plugin-panel panel panel-primary">'
                          . '<div class="panel-body">test</div></div>',
            ),
            'twbs_success' => array(
                'panel' => array('success'),
                'assert' => '<div class="haik-plugin-panel panel panel-success">'
                          . '<div class="panel-body">test</div></div>',
            ),
            'twbs_info' => array(
                'panel' => array('info'),
                'assert' => '<div class="haik-plugin-panel panel panel-info">'
                          . '<div class="panel-body">test</div></div>',
            ),
            'twbs_warning' => array(
                'panel' => array('warning'),
                'assert' => '<div class="haik-plugin-panel panel panel-warning">'
                          . '<div class="panel-body">test</div></div>',
            ),
            'twbs_danger' => array(
                'panel' => array('danger'),
                'assert' => '<div class="haik-plugin-panel panel panel-danger">'
                          . '<div class="panel-body">test</div></div>',
            ),

        );

        foreach ($tests as $key => $data)
        {
            $this->assertEquals($data['assert'], with(new PanelPlugin)->convert($data['panel'], 'test'));
        }
        $this->markTestIncomplete(
            'This test is Incomplete'
        );
    }


    public function testParameterWithHeading()
    {
        $tests = array(
            'default' => array(
                'panel' => array(),
                'assert' => '<div class="haik-plugin-panel panel panel-default">'
                          . '<div class="panel-heading">test title</div>'
                          . '<div class="panel-body">test</div></div>',
            ),
            'twbs_primary' => array(
                'panel' => array('primary'),
                'assert' => '<div class="haik-plugin-panel panel panel-primary">'
                          . '<div class="panel-heading">test title</div>'
                          . '<div class="panel-body">test</div></div>',
            ),
            'twbs_success' => array(
                'panel' => array('success'),
                'assert' => '<div class="haik-plugin-panel panel panel-success">'
                          . '<div class="panel-heading">test title</div>'
                          . '<div class="panel-body">test</div></div>',
            ),
            'twbs_info' => array(
                'panel' => array('info'),
                'assert' => '<div class="haik-plugin-panel panel panel-info">'
                          . '<div class="panel-heading">test title</div>'
                          . '<div class="panel-body">test</div></div>',
            ),
            'twbs_warning' => array(
                'panel' => array('warning'),
                'assert' => '<div class="haik-plugin-panel panel panel-warning">'
                          . '<div class="panel-heading">test title</div>'
                          . '<div class="panel-body">test</div></div>',
            ),
            'twbs_danger' => array(
                'panel' => array('danger'),
                'assert' => '<div class="haik-plugin-panel panel panel-danger">'
                          . '<div class="panel-heading">test title</div>'
                          . '<div class="panel-body">test</div></div>',
            ),

        );

        foreach ($tests as $key => $data)
        {
            $this->assertEquals($data['assert'], with(new PanelPlugin)->convert($data['panel'], 'test title\n====\ntest'));
        }
        $this->markTestIncomplete(
            'This test is Incomplete'
        );
    }


    public function testHeadingParse()
    {
        $md_heading1 = array(
            'panel' => array(),
            'assert' => '<div class="haik-plugin-panel panel panel-default">'
                      . '<div class="panel-heading">'
                      . '<h1 class="panel-title">test title</h1></div>'
                      . '<div class="panel-body">test</div></div>',
        );
        $this->assertEquals($md_heading1['assert'],
                            with(new PanelPlugin)->convert($md_heading1['panel'], '# test title\n====\ntest'));


        $md_heading6 = array(
            'panel' => array(),
            'assert' => '<div class="haik-plugin-panel panel panel-default">'
                      . '<div class="panel-heading">'
                      . '<h6 class="panel-title">test title</h1></div>'
                      . '<div class="panel-body">test</div></div>',
        );
        $this->assertEquals($md_heading6['assert'],
                            with(new PanelPlugin)->convert($md_heading6['panel'], '###### test title\n====\ntest'));


        $html_heading1 = array(
            'panel' => array(),
            'assert' => '<div class="haik-plugin-panel panel panel-default">'
                      . '<div class="panel-heading">'
                      . '<h1 class="panel-title">test title</h1></div>'
                      . '<div class="panel-body">test</div></div>',
        );
        $this->assertEquals($html_heading1['assert'],
                            with(new PanelPlugin)->convert($html_heading1['panel'], '<h1>test title</h1>\n====\ntest'));


        $html_heading6 = array(
            'panel' => array(),
            'assert' => '<div class="haik-plugin-panel panel panel-default">'
                      . '<div class="panel-heading">'
                      . '<h6 class="panel-title">test title</h6></div>'
                      . '<div class="panel-body">test</div></div>',
        );
        $this->assertEquals($html_heading6['assert'],
                            with(new PanelPlugin)->convert($html_heading6['panel'], '<h6>test title</h6>\n====\ntest'));


        $directly_html_heading1 = array(
            'panel' => array(),
            'assert' => '<div class="haik-plugin-panel panel panel-default">'
                      . '<div class="panel-heading">'
                      . '<h1 class="panel-title">test title</h1></div>'
                      . '<div class="panel-body">test</div></div>',
        );
        $this->assertEquals($directly_html_heading1['assert'], 
                            with(new PanelPlugin)->convert($directly_html_heading1['panel'], '<h1 class="panel-title">test title</h1>\n====\ntest'));


        $directly_html_heading6 = array(
            'panel' => array(),
            'assert' => '<div class="haik-plugin-panel panel panel-default">'
                      . '<div class="panel-heading">'
                      . '<h6 class="panel-title">test title</h6></div>'
                      . '<div class="panel-body">test</div></div>',
        );
        $this->assertEquals($directly_html_heading6['assert'], 
                            with(new PanelPlugin)->convert($directly_html_heading6['panel'], '<h6 class="panel-title">test title</h6>\n====\ntest'));


        $this->markTestIncomplete(
            'This test is Incomplete'
        );
    }
}