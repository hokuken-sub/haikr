<?php

class HaikUsersTableSeeder extends Seeder {

    public function run()
    {
        DB::table('haik_users')->truncate();

        User::create(array(
                'name' => 'toiee',
                'email' => 'touch@toiee.jp',
                'password' => 'makeit',
        ));
        
    }
}