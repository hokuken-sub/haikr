<?php
use Toiee\haik\Plugins\Alert\AlertPlugin;

class AlertPluginTest extends TestCase {

    public function testConvertMethodExists()
    {
        $this->assertInternalType('string', with(new AlertPlugin)->convert());

    }

}