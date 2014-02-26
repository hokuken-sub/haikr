<?php
use Toiee\haik\Plugins\Thumbnails\ThumbnailsPlugin;


class ThumbnailsPluginTest extends TestCase {

    public function testConvertMethodExists()
    {
        $this->assertInternalType('string', with(new ThumbnailsPlugin)->convert());
    }

}