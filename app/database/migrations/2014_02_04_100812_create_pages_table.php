<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//

        Schema::create('pages', function($table)
        {
             $table->increments('id')->unsigned();
             $table->integer('haik_site_id')->unsigned();
             $table->string('pagename');
             $table->string('title')->nullable();
             $table->text('contents');
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
		Schema::drop('pages');
	}

}
