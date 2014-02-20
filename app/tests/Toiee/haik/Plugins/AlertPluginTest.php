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
                'assert' => '<div class="alert alert-warning">test</div>',
            ),
            'success' => array(
                'alert' => array('success'),
                'assert' => '<div class="alert alert-success">test</div>',
            ),
        );

        foreach ($tests as $key => $data)
        {
            $this->assertEquals($data['assert'], with(new AlertPlugin)->convert($data['alert'], 'test'));
        }

        $this->markTestIncomplete(
            'This test is Incomplete.'
        );
    }

}