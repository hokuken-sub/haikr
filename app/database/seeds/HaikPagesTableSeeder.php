<?php

class HaikPagesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('haik_pages')->truncate();

        Page::create(array(
                'haik_site_id' => 1,
                'name' => 'FrontPage',
                'title' => '',
                'body' => '# Test Test',
                // :
        ));
        
        Page::create(array(
                'haik_site_id' => 1,
                'name' => 'Contact',
                'title' => 'お問い合わせ',
                'body' => '# Test Test',
                // :
        ));
        
    }
}