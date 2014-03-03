<?php
use Toiee\haik\Plugins\Utility;

class UtilityTest extends TestCase {

    public function testParseColumnDataExists()
    {
        # return array if parseColumnData work correctly.
        $this->assertInternalType('array', Utility::parseColumnData('12'));
    }

    public function testParseColumnDataNotExists()
    {
        # return FALSE if parseColumnData not work correctly.
        $this->assertFalse(Utility::parseColumnData('three'));
    }

    /**
     * @dataProvider columnDataProvider
     */
    public function testParameter($columndata, $assert)
    {
        $this->assertEquals($assert, Utility::parseColumnData($columndata));
    }

    public function columnDataProvider()
    {
        $tests = array(
            'no_data' => array(
                'columndata' => '',
                'assert'     => false,
            ),
            'one_num_data' => array(
                'columndata' => '12',
                'assert'     => array(
                    'cols'   => 12,
                    'offset' => 0,
                    'class'  => '',
                ),
            ),
            'num_and_offset_data' => array(
                'columndata' => '3+1',
                'assert'     => array(
                    'cols'   => 3,
                    'offset' => 1,
                    'class'  => '',
                ),
            ),
            'num_and_class_data' => array(
                'columndata' => '3.classname',
                'assert'     => array(
                    'cols'   => 3,
                    'offset' => 0,
                    'class'  => 'classname',
                ),
            ),
            'num_and_doubleclass_data' => array(
                'columndata' => '3.classname1.classname2',
                'assert'     => array(
                    'cols'   => 3,
                    'offset' => 0,
                    'class'  => 'classname1 classname2',
                ),
            ),
            'num_and_offset_and_class_data' => array(
                'columndata' => '3+3.classname',
                'assert'     => array(
                    'cols'   => 3,
                    'offset' => 3,
                    'class'  => 'classname',
                ),
            ),
        );
        return $tests;
    }
}