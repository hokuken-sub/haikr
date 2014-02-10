<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHaikSitePermissionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	  //
        Schema::create('haik_site_permissions', function($table)
        {
             $table->increments('id')->unsigned();
             $table->integer('haik_site_id')->unsigned();
             $table->integer('haik_user_id')->unsigned();
             $table->string('permissions');
             $table->dateTime('expirating_date')->nullable();
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	  //
        Schema::drop('haik_site_permissions');
    }
    
}
