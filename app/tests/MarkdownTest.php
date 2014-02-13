<?php

use Michelf\MarkdownExtra;

class MarkdownTest extends TestCase {

    public function testHeader()
    {
        $tests = array(
            'normal' => array(
                'markdown' => '#header',
                'assert'   => '<h1>header</h1>'
            )
        );
        foreach ($tests as $test)
        {
            $result = trim(MarkdownExtra::defaultTransform($test['markdown']));
            $this->assertEquals($test['assert'], $result);
        }
    }
    
    public function testStrong()
    {
        $tests = array(
            'normal' => array(
                'markdown' => '**Strong**',
                'assert'   => '<p><strong>Strong</strong></p>'
            ),
            'with_link' => array(
                'markdown' => '[**Google**](http://google.com)',
                'assert'   => '<p><a href="http://google.com"><strong>Google</strong></a></p>'
            ),
            'break' => array(
                'markdown' => "**St\nrong**",
                'assert'   => "<p><strong>St\nrong</strong></p>"
            ),
            'double_break' => array(
                'markdown' => "**St\n\nrong**",
                'assert'   => "<p>**St</p>\n\n<p>rong**</p>"
            ),
            'with_header' => array(
                'markdown' => '#**Header**',
                'assert'   => '<h1><strong>Header</strong></h1>'
            )
        );

        foreach ($tests as $test)
        {
            $result = trim(MarkdownExtra::defaultTransform($test['markdown']));
            $this->assertEquals($test['assert'], $result);
        }
    }
}