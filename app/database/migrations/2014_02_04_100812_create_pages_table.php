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
    
          Schema::create('haik_pages', function($table)
          {
               $table->increments('id')->unsigned();
               $table->integer('haik_site_id')->unsigned();
               $table->string('name');
               $table->string('title')->nullable();
               $table->text('body');
               $table->text('description')->nullable();
               $table->text('head')->nullable();
               $table->text('script')->nullable();
               $table->string('layout')->nullable();
               $table->string('listing')->default('list');
               $table->string('public')->default('public');
               $table->integer('body_version')->unsigined()->default(0);
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
    	  Schema::drop('haik_pages');
    }

}
