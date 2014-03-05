<?php
use Toiee\haik\Entities\HaikMarkdown;

class HaikMarkdownTest extends TestCase {

    public function setupPluginRepositoryInterface()
    {
        App::bind('PluginRepositoryInterface', function(){
            $mock = Mockery::mock('Toiee\haik\Plugins\PluginRepositoryInterface');
            $mock->shouldReceive('exists')
                 ->once()
                 ->andReturn(true);
            $mock->shouldReceive('load')
                 ->once()
                 ->andReturn(App::make('PluginInterface'));
            return $mock;
        });
    }
    
    public function testEmptyElementSuffix()
    {
        $parser = new HaikMarkdown;
        $this->assertEquals('>', $parser->empty_element_suffix);
    }
    
    public function testCodeClassPrefix()
    {
        $parser = new HaikMarkdown;
        $this->assertEquals('', $parser->code_class_prefix);
    }
    
    public function testDoHaikLinks()
    {
        $parser = new HaikMarkdown;

        $tests = array(
            'toppage' => array(
                'markdown' => '[[FrontPage]]',
                'assert'   => '<p><a href="http://localhost:8000/" title="FrontPage">FrontPage</a></p>',
            ),
            'otherpage' => array(
                'markdown' => '[[Contact]]',
                'assert'   => '<p><a href="http://localhost:8000/Contact.html" title="Contact">Contact</a></p>',
            ),
            'toppage#hash' => array(
                'markdown' => '[[FrontPage#hash]]',
                'assert'   => '<p><a href="http://localhost:8000/#hash" title="FrontPage">FrontPage</a></p>',
            ),
            'otherpage#hash' => array(
                'markdown' => '[[Contact#hash]]',
                'assert'   => '<p><a href="http://localhost:8000/Contact.html#hash" title="Contact">Contact</a></p>',
            ),
            '>toppage' => array(
                'markdown' => '[[Top>FrontPage]]',
                'assert'   => '<p><a href="http://localhost:8000/" title="Top">Top</a></p>',
            ),
            '>otherpage' => array(
                'markdown' => '[[Touch me!>Contact]]',
                'assert'   => '<p><a href="http://localhost:8000/Contact.html" title="Touch me!">Touch me!</a></p>',
            ),
            '#hashonly' => array(
                'markdown' => '[[#hash]]',
                'assert'   => '<p><a href="#hash">hash</a></p>',
            ),
            '>#hashonly' => array(
                'markdown' => '[[Alias>#hash]]',
                'assert'   => '<p><a href="#hash" title="Alias">Alias</a></p>',
            ),
            'url' => array(
                'markdown' => '[[http://www.google.com]]',
                'assert' => '<p><a href="http://www.google.com">http://www.google.com</a></p>',
            ),
            '>url' => array(
                'markdown' => '[[Google>http://www.google.com]]',
                'assert' => '<p><a href="http://www.google.com" title="Google">Google</a></p>',
            ),
            'alias_contain_markdown' => array(
                'markdown' => '[[Touch **me**!>Contact]]',
                'assert'   => '<p><a href="http://localhost:8000/Contact.html" title="Touch me!">Touch <strong>me</strong>!</a></p>',
            ),
        );
        
        foreach ($tests as $key => $data)
        {
            $this->assertEquals($data['assert'], trim($parser->transform($data['markdown'])));
        }
        
    }
    
    // ! inline plugin
    
    public function testCallInlinePluginsWithAllVariations()
    {
        App::bind('PluginInterface', function(){
            $mock = Mockery::mock('Toiee\haik\Plugins\PluginInterface');
            $mock->shouldReceive('inline')
                 ->andReturn('<span>inline plugin</span>');
            return $mock;
        });

        $this->setupPluginRepositoryInterface();
    
        $parser = new HaikMarkdown;
        
        $tests = array(
            'plugin_name_only' => array(
                'markdown' => '&plugin;',
                'assert'   => '<p><span>inline plugin</span></p>',
            ),
            'plugin_name_and_params' => array(
                'markdown' => '&plugin(param1,param2);',
                'assert'   => '<p><span>inline plugin</span></p>',
            ),
            'plugin_name_and_body' => array(
                'markdown' => '&plugin{body};',
                'assert'   => '<p><span>inline plugin</span></p>',
            ),
            'plugin_name_and_params_and_body' => array(
                'markdown' => '&plugin(param1,param2){body};',
                'assert'   => '<p><span>inline plugin</span></p>',
            ),
        );
        
        foreach ($tests as $key => $data)
        {
            $this->assertEquals($data['assert'], trim($parser->transform($data['markdown'])));
        }
    }

    public function testCallInlinePluginWithParams()
    {
        App::bind('PluginInterface', function(){
            $mock = Mockery::mock('Toiee\haik\Plugins\PluginInterface');
            $mock->shouldReceive('inline')
                 ->with(array('param1','param2'), '')
                 ->andReturn('<span>inline plugin</span>');
            return $mock;
        });

        $this->setupPluginRepositoryInterface();

        $parser = new HaikMarkdown;

        $markdown = '&plugin(param1,param2);';
        $assert   = '<p><span>inline plugin</span></p>';

        $this->assertEquals($assert, trim($parser->transform($markdown)));
    }

    public function testCallInlinePluginWithBody()
    {
        App::bind('PluginInterface', function(){
            $mock = Mockery::mock('Toiee\haik\Plugins\PluginInterface');
            $mock->shouldReceive('inline')
                 ->with(array(), 'body')
                 ->andReturn('<span>inline plugin</span>');
            return $mock;
        });

        $this->setupPluginRepositoryInterface();

        $parser = new HaikMarkdown;

        $markdown = '&plugin{body};';
        $assert   = '<p><span>inline plugin</span></p>';

        $this->assertEquals($assert, trim($parser->transform($markdown)));
    }

    public function testCallInlinePluginWithParamsAndBody()
    {
        App::bind('PluginInterface', function(){
            $mock = Mockery::mock('Toiee\haik\Plugins\PluginInterface');
            $mock->shouldReceive('inline')
                 ->with(array('param1', 'param2'), 'body')
                 ->andReturn('<span>inline plugin</span>');
            return $mock;
        });

        $this->setupPluginRepositoryInterface();

        $parser = new HaikMarkdown;

        $markdown = '&plugin(param1,param2){body};';
        $assert   = '<p><span>inline plugin</span></p>';

        $this->assertEquals($assert, trim($parser->transform($markdown)));
    }

    public function testCallInlinePluginWithParamsContainsDoubleQuotes()
    {
        App::bind('PluginInterface', function(){
            $mock = Mockery::mock('Toiee\haik\Plugins\PluginInterface');
            $mock->shouldReceive('inline')
                 ->with(array('param,1', 'param2,'), '')
                 ->andReturn('<span>inline plugin</span>');
            return $mock;
        });

        $this->setupPluginRepositoryInterface();

        $parser = new HaikMarkdown;

        $markdown = '&plugin("param,1","param2,");';
        $assert   = '<p><span>inline plugin</span></p>';

        $this->assertEquals($assert, trim($parser->transform($markdown)));
    }

    public function testCallInlinePluginWithParamsContainsEscapedDoubleQuotes()
    {
        App::bind('PluginInterface', function(){
            $mock = Mockery::mock('Toiee\haik\Plugins\PluginInterface');
            $mock->shouldReceive('inline')
                 ->with(array('param"1"', 'param2'), '')
                 ->andReturn('<span>inline plugin</span>');
            return $mock;
        });

        $this->setupPluginRepositoryInterface();

        $parser = new HaikMarkdown;

        $markdown = '&plugin("param""1""","param2");';
        $assert   = '<p><span>inline plugin</span></p>';

        $this->assertEquals($assert, trim($parser->transform($markdown)));

        $markdown = '&plugin(param"1",param2);';
        $assert   = '<p><span>inline plugin</span></p>';

        $this->assertEquals($assert, trim($parser->transform($markdown)));
    }

    public function testCallNestedInlinePlugins()
    {
        $parser = new HaikMarkdown;

        $markdown = '&deco(b){&deco(red){body};};';
        $assert   = '<p><span class="haik-plugin-deco"><strong><span class="haik-plugin-deco" style="color:red;">body</span></strong></span></p>';

        $this->assertEquals($assert, trim($parser->transform($markdown)));
    }
    
    public function testCallInlinePluginTwiceInAParagraph()
    {
        App::bind('PluginInterface', function(){
            $mock = Mockery::mock('Toiee\haik\Plugins\PluginInterface');
            $mock->shouldReceive('inline')
                 ->with(array('param'), '')
                 ->andReturn('<span>inline plugin</span>');
            return $mock;
        });

        $this->setupPluginRepositoryInterface();

        $parser = new HaikMarkdown;

        $markdown = '&plugin(param);foo&plugin(param);';
        $assert   = '<p><span>inline plugin</span>foo<span>inline plugin</span></p>';

        $this->assertEquals($assert, trim($parser->transform($markdown)));

    }

    public function testCallInlinePluginWithNotExistedName()
    {
        App::bind('PluginRepositoryInterface', function(){
            $mock = Mockery::mock('Toiee\haik\Plugins\PluginRepositoryInterface');
            $mock->shouldReceive('exists')
                 ->once()
                 ->andReturn(false);
            return $mock;
        });
    
        $parser = new HaikMarkdown;
        
        $markdown = '&plugin;hr&plugin;';
        $assert   = '<p>&plugin;hr&plugin;</p>';
        
        $this->assertEquals($assert, trim($parser->transform($markdown)));
    }

    // ! convert plugin
    
    public function testCallConvertPluginWithAllVariations()
    {
        App::bind('PluginInterface', function(){
            $mock = Mockery::mock('Toiee\haik\Plugins\PluginInterface');
            $mock->shouldReceive('convert')
                 ->andReturn('<div>convert plugin</div>');
            return $mock;
        });

        $this->setupPluginRepositoryInterface();
    
        $parser = new HaikMarkdown;
        
        $tests = array(
            'plugin_name_only' => array(
                'markdown' => '{#plugin}',
                'assert'   => '<div>convert plugin</div>',
            ),
            'plugin_name_and_params' => array(
                'markdown' => '{#plugin(param1,param2)}',
                'assert'   => '<div>convert plugin</div>',
            ),
            'plugin_name_and_body' => array(
                'markdown' => ":::{#plugin}\nbody\n:::",
                'assert'   => '<div>convert plugin</div>',
            ),
            'plugin_name_and_params_and_body' => array(
                'markdown' => ":::{#plugin(param1,param2)}\nbody\n:::",
                'assert'   => '<div>convert plugin</div>',
            ),
        );
        
        foreach ($tests as $key => $data)
        {
            $this->assertEquals($data['assert'], trim($parser->transform($data['markdown'])));
        }
    }
    
    public function testCallConvertPluginWithParams()
    {
        App::bind('PluginInterface', function(){
            $mock = Mockery::mock('Toiee\haik\Plugins\PluginInterface');
            $mock->shouldReceive('convert')
                 ->with(array('param1','param2'), '')
                 ->andReturn('<div>convert plugin</div>');
            return $mock;
        });

        $this->setupPluginRepositoryInterface();

        $parser = new HaikMarkdown;

        $markdown = '{#plugin(param1,param2)}';
        $assert   = '<div>convert plugin</div>';

        $this->assertEquals($assert, trim($parser->transform($markdown)));    }
    
    public function testCallConvertPluginWithBody()
    {
        App::bind('PluginInterface', function(){
            $mock = Mockery::mock('Toiee\haik\Plugins\PluginInterface');
            $mock->shouldReceive('convert')
                 ->with(array(), "body\n")
                 ->andReturn('<div>convert plugin</div>');
            return $mock;
        });

        $this->setupPluginRepositoryInterface();

        $parser = new HaikMarkdown;

        $markdown = ":::{#plugin}\nbody\n:::";
        $assert   = '<div>convert plugin</div>';
        $this->assertEquals($assert, trim($parser->transform($markdown)));    }
    
    public function testCallConvertPluginWithParamsAndBody()
    {
        App::bind('PluginInterface', function(){
            $mock = Mockery::mock('Toiee\haik\Plugins\PluginInterface');
            $mock->shouldReceive('convert')
                 ->with(array('param1', 'param2'), "body\n")
                 ->andReturn('<div>convert plugin</div>');
            return $mock;
        });

        $this->setupPluginRepositoryInterface();

        $parser = new HaikMarkdown;

        $markdown = ":::{#plugin(param1,param2)}\nbody\n:::";
        $assert   = '<div>convert plugin</div>';

        $this->assertEquals($assert, trim($parser->transform($markdown)));
    }

    public function testCallConvertPluginWithParamsContainsDoubleQuotes()
    {
        App::bind('PluginInterface', function(){
            $mock = Mockery::mock('Toiee\haik\Plugins\PluginInterface');
            $mock->shouldReceive('convert')
                 ->with(array('param,1', 'param2,'), '')
                 ->andReturn('<div>Convert plugin</div>');
            return $mock;
        });

        $this->setupPluginRepositoryInterface();

        $parser = new HaikMarkdown;

        $markdown = '{#plugin("param,1","param2,")}';
        $assert   = '<div>Convert plugin</div>';

        $this->assertEquals($assert, trim($parser->transform($markdown)));
    }

    public function testCallConvertPluginWithParamsContainsEscapedDoubleQuotes()
    {
        App::bind('PluginInterface', function(){
            $mock = Mockery::mock('Toiee\haik\Plugins\PluginInterface');
            $mock->shouldReceive('convert')
                 ->with(array('param"1"', 'param2'), '')
                 ->andReturn('<div>Convert plugin</div>');
            return $mock;
        });

        $this->setupPluginRepositoryInterface();

        $parser = new HaikMarkdown;

        $markdown = '{#plugin("param""1""","param2")}';
        $assert   = '<div>Convert plugin</div>';

        $this->assertEquals($assert, trim($parser->transform($markdown)));

        $markdown = '{#plugin(param"1",param2)}';
        $assert   = '<div>Convert plugin</div>';

        $this->assertEquals($assert, trim($parser->transform($markdown)));
    }
    
    public function testCallConvertPluginTwice()
    {
        App::bind('PluginInterface', function(){
            $mock = Mockery::mock('Toiee\haik\Plugins\PluginInterface');
            $mock->shouldReceive('convert')
                 ->with(array(), '')
                 ->andReturn('<div>Convert plugin</div>');
            return $mock;
        });

        $this->setupPluginRepositoryInterface();

        $parser = new HaikMarkdown;

        $markdown = "{#plugin}\n{#plugin}";
        $assert   = "<div>Convert plugin</div>\n\n<div>Convert plugin</div>";

        $this->assertEquals($assert, trim($parser->transform($markdown)));

    }

    public function testCallConvertPluginWithNotExistedName()
    {
        App::bind('PluginRepositoryInterface', function(){
            $mock = Mockery::mock('Toiee\haik\Plugins\PluginRepositoryInterface');
            $mock->shouldReceive('exists')
                 ->once()
                 ->andReturn(false);
            return $mock;
        });
    
        $parser = new HaikMarkdown;
        
        $markdown = "::: {#plugin}\nhoge\n:::";
        $assert   = "<p>::: {#plugin}\nhoge\n:::</p>";
        
        $this->assertEquals($assert, trim($parser->transform($markdown)));
    }
    // !TODO: 具体クラスでテストする
    public function testCallNestedConvertPlugins()
    {
        
    }
    
}