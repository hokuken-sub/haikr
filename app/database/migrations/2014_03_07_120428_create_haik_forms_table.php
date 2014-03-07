<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHaikFormsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
    
          Schema::create('haik_forms', function($table)
          {
               $table->increments('id')->unsigned();
               $table->integer('haik_site_id')->unsigned();
               $table->string('key');
               $table->string('note')->nullable();
               $table->text('body')->nullable();
               $table->text('transaction')->nullable();
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
        Schema::drop('haik_forms');
    }

}
