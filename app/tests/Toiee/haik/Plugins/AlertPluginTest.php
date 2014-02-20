<?php
use Toiee\haik\Plugins\Alert\AlertPlugin;

class AlertPluginTest extends TestCase {

    public function testConvertMethodExists()
    {
        $this->assertInternalType('string', with(new AlertPlugin)->convert());
    }

    public function testParameter()
    {
        $tests = array(
            'no_params' => array(
                'alert' => array(),
                'assert' => '<div class="alert alert-warning">'.\Parser::parse('test').'</div>',
            ),
            'success' => array(
                'alert' => array('success'),
                'assert' => '<div class="alert alert-success">'.\Parser::parse('test').'</div>',
            ),
            'custom_class' => array(
                'alert' => array('hogehoge'),
                'assert' => '<div class="alert alert-warning hogehoge">'.\Parser::parse('test').'</div>',
            ),
            'with_close' => array(
                'alert' => array('info', 'close'),
                'assert' => '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.\Parser::parse('test').'</div>',
            ),
        );

        foreach ($tests as $key => $data)
        {
            $this->assertEquals($data['assert'], with(new AlertPlugin)->convert($data['alert'], 'test'));
        }
    }

}