<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHaikSitesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//

        Schema::create('haik_sites', function($table)
        {
             $table->increments('id')->unsigned();
             $table->string('domain')->default('*');
             $table->string('directory')->nullable();
             $table->string('title')->default('');
             $table->text('description')->nullable();
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
		  Schema::drop('haik_sites');
	}

}
