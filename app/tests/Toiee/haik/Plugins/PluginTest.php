<?php

use Toiee\haik\Plugins\Plugin;
use Toiee\haik\Plugins\PluginCounter;
use Toiee\haik\Plugins\Deco\DecoPlugin;
use Toiee\haik\Plugins\Cols\ColsPlugin;
use Toiee\haik\Plugins\Panel\PanelPlugin;
use Toiee\haik\Plugins\Icon\IconPlugin;

class PluginTest extends TestCase {

    public function testCount()
    {
        $panel = new PanelPlugin();
        $count = PluginCounter::get('PanelPlugin');
        $this->assertEquals(1, $count);

        $icon = new IconPlugin();
        $icon = new IconPlugin();
        $count = PluginCounter::get('IconPlugin');
        $this->assertEquals(2, $count);
    }

    public function testId()
    {
        $deco1 = new DecoPlugin();
        $id = $deco1->getId();
        $this->assertEquals(1, $id);

        $plugin2 = new DecoPlugin();
        $plugin3 = new DecoPlugin();
        
        $this->assertEquals(3, $plugin3->getId());
        
        $cols1 = new ColsPlugin();
        $cols2 = new ColsPlugin();

        $this->assertEquals(2, $cols2->getId());
    }
}