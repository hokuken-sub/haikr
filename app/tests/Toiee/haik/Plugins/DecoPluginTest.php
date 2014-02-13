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
}