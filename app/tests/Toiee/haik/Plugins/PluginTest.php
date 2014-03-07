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
        $count_before_inc = PluginCounter::get('PanelPlugin');
        $panel = new PanelPlugin();
        $count = PluginCounter::get('PanelPlugin');
        $this->assertEquals($count_before_inc + 1, $count);

        $count_before_inc = PluginCounter::get('IconPlugin');
        $icon = new IconPlugin();
        $icon = new IconPlugin();
        $count = PluginCounter::get('IconPlugin');
        $this->assertEquals($count_before_inc + 2, $count);
    }

    public function testId()
    {
        $deco1 = new DecoPlugin();
        $id = $deco1->getId();
        $current_count = PluginCounter::get('DecoPlugin');
        $this->assertEquals($current_count, $id);

        $plugin2 = new DecoPlugin();
        $plugin3 = new DecoPlugin();
        $current_count = PluginCounter::get('DecoPlugin');
        
        $this->assertEquals($current_count, $plugin3->getId());
        
        $cols1 = new ColsPlugin();
        $cols2 = new ColsPlugin();
        $current_count = PluginCounter::get('ColsPlugin');

        $this->assertEquals($current_count, $cols2->getId());
    }
}
