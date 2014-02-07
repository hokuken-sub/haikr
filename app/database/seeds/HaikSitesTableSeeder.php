<?php

class HaikSitesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('haik_sites')->truncate();

        Site::create(array(
                'haik_user_id' => 1,
                'title' => '',
                'description' => '',
                // :
        ));
        
    }
}