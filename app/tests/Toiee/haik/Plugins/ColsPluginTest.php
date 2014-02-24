<?php
use Toiee\haik\Plugins\Cols\ColsPlugin;


class ColsPluginTest extends TestCase {

    public function testConvertMethodExists()
    {
        $this->assertInternalType('string', with(new ColsPlugin)->convert());
    }

}