<?php

class HaikPagesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('haik_pages')->truncate();

        Page::create(array(
                'haik_site_id' => 1,
                'pagename' => 'FrontPage',
                'title' => '',
                'contents' => '# Test Test',
                // :
        ));
        
        Page::create(array(
                'haik_site_id' => 1,
                'pagename' => 'Contact',
                'title' => 'お問い合わせ',
                'contents' => '# Test Test',
                // :
        ));
        
    }
}