<?php
use Toiee\haik\Plugins\Cols\ColsPlugin;


class ColsPluginTest extends TestCase {

    public function testConvertMethodExists()
    {
        $this->assertInternalType('string', with(new ColsPlugin)->convert());
    }

    public function testParameter()
    {
        $tests = array(
            'no_params' => array(
                'cols'   => array(),
                'assert' => array(
                    array (
                        'cols'   => 12,
                        'offset' => 0,
                        'class'  => '',
                        'style'  => '',
                        'body'   => '',
                    ),
                )
            ),
            'only1num' => array(
                'cols'   => array(),
                'assert' => array(
                    array (
                        'cols'   => 3,
                        'offset' => 0,
                        'class'  => '',
                        'style'  => '',
                        'body'   => '',
                    ),
                )
            ),
        );

        foreach ($tests as $key => $data)
        {
            $cols = new ColsPlugin;
            $cols->convert($data['cols'], '');
            $this->assertAttributeSame($data['assert'], 'cols', $cols);
        }
    }

}