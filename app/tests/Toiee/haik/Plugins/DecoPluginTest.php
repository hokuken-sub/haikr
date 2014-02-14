<?php
use Toiee\haik\Plugins\Deco\DecoPlugin;

class DecoPluginTest extends TestCase {

    public function testInlineMethodExists()
    {
        App::bind('PluginRepositoryInterface', function(){
            $mock = Mockery::mock('Toiee\haik\Repositories\PluginRepositoryInterface');
            $mock->shouldReceive('exists')
                 ->once()
                 ->andReturn(true);
            $mock->shouldReceive('load')
                  ->once()
                  ->andReturn(new DecoPlugin);
            return $mock;
        });
        
        $this->assertInternalType('string', Plugin::get('deco')->inline());
    }
    
    public function testParameter()
    {
        App::bind('PluginRepositoryInterface', function(){
            $mock = Mockery::mock('Toiee\haik\Repositories\PluginRepositoryInterface');
            $mock->shouldReceive('exists')
                 ->once()
                 ->andReturn(true);
            $mock->shouldReceive('load')
                  ->once()
                  ->andReturn(new DecoPlugin);
            return $mock;
        });

        $tests = array(
            'none' => array(
                'deco' => array(),
                'assert' => '<span class="haik-plugin-deco">test</span>',
            ),
            'b' => array(
                'deco' => array('b'),
                'assert' => '<span class="haik-plugin-deco"><strong>test</strong></span>',
            ),
            'bold' => array(
                'deco' => array('b'),
                'assert' => '<span class="haik-plugin-deco"><strong>test</strong></span>',
            ),
            'u' => array(
                'deco' => array('u'),
                'assert' => '<span class="haik-plugin-deco" style="text-decoration:underline;">test</span>',
            ),
            'bu' => array(
                'deco' => array('b','u'),
                'assert' => '<span class="haik-plugin-deco" style="text-decoration:underline;"><strong>test</strong></span>',
            ),
            'color' => array(
                'deco' => array('#fff'),
                'assert' => '<span class="haik-plugin-deco" style="color:#fff;">test</span>',
            ),
            'bgcolor' => array(
                'deco' => array('','#000'),
                'assert' => '<span class="haik-plugin-deco" style="color:inherit;background-color:#000;">test</span>',
            ),
            'b-color' => array(
                'deco' => array('b','#fff'),
                'assert' => '<span class="haik-plugin-deco" style="color:#fff;"><strong>test</strong></span>',
            ),
        );
        
        foreach ($tests as $key => $data)
        {
            $this->assertEquals($data['assert'], Plugin::get('deco')->inline($data['deco'],'test'));
        }
    }
}