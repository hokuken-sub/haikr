<?php
use Toiee\haik\Entities\HaikMarkdown;

class HaikMarkdownTest extends TestCase {
    
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
                'assert'   => '<p><a href="http://localhost:8000" title="FrontPage">FrontPage</a></p>',
            ),
            'otherpage' => array(
                'markdown' => '[[Contact]]',
                'assert'   => '<p><a href="http://localhost:8000/Contact" title="Contact">Contact</a></p>',
            ),
            'toppage#hash' => array(
                'markdown' => '[[FrontPage#hash]]',
                'assert'   => '<p><a href="http://localhost:8000/#hash" title="FrontPage">FrontPage</a></p>',
            ),
            'otherpage#hash' => array(
                'markdown' => '[[Contact#hash]]',
                'assert'   => '<p><a href="http://localhost:8000/Contact#hash" title="Contact">Contact</a></p>',
            ),
            '>toppage' => array(
                'markdown' => '[[Top>FrontPage]]',
                'assert'   => '<p><a href="http://localhost:8000" title="Top">Top</a></p>',
            ),
            '>otherpage' => array(
                'markdown' => '[[Touch me!>Contact]]',
                'assert'   => '<p><a href="http://localhost:8000/Contact" title="Touch me!">Touch me!</a></p>',
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
        );
        
        foreach ($tests as $key => $data)
        {
            $this->assertEquals($data['assert'], trim($parser->transform($data['markdown'])));
        }
        
    }
    
    public function testDoInlinePlugins()
    {
        $parser = new HaikMarkdown;
        
        $tests = array(
            'normal_strong' => array(
                'markdown' => '&deco(b){DECO};',
                'assert'   => '<span class="haik-deco"><strong>DECO</strong></span>',
            ),
            'normal_strong_red' => array(
                'markdown' => '&deco(b,red){DECO};',
                'assert'   => '<span class="haik-deco" style="color:red"><strong>DECO</strong></span>',
            ),
            'with_markdown_strong' => array(
                'markdown' => '&deco(b){*Italic*};',
                'assert'   => '<span class="haik-deco"><strong><em>Italic</em></strong></span>',
            ),
        );
        
        foreach ($tests as $key => $data)
        {
            $this->assertEquals($data['assert'], $parser->transform($data['markdown']));
        }
    }
}