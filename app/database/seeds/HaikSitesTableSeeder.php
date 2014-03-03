<?php

class HaikSitesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('haik_sites')->truncate();

        Site::create(array(
                'key' => 'master',
                'title' => '',
                'description' => '',
                // :
        ));
        
    }
}