<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHaikFilesTable extends Migration {

    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('haik_files', function($table)
        {
            $table->increments('id')->unsigned();
            $table->integer('haik_site_id')->unsigned();
            $table->string('key');
            $table->string('type');
            $table->string('mime_type')->nullable();
            $table->integer('size')->unsigined()->default(0);
            $table->string('dimensions')->nullable();
            $table->boolean('starred')->default(false);
            $table->binary('value')->nullable();
            $table->string('ext')->nullable();
            $table->string('storage');
            $table->boolean('publicity')->default(true);
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
        Schema::drop('haik_files');
    }

}
