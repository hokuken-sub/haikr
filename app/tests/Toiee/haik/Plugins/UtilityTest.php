<?php
use Toiee\haik\Plugins\Utility;

class UtilityTest extends TestCase {

    public function testParseColumnDateExists()
    {
        # return array if parseColumnData work correctly.
        $this->assertInternalType('array', Utility::parseColumnData('12'));
    }

    public function testParseColumnDataNotExists()
    {
        # return FALSE if parseColumnData not work correctly.
        $this->assertFalse(Utility::parseColumnData('three'));
    }
}