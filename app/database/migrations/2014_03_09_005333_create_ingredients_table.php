<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIngredientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('ingredients', function(Blueprint $table) {
            $table->increments('id');
	        $table->string('name',255);
	        $table->string('rating',10)->nullable();
	        $table->string('function',255)->nullable();
	        $table->string('benefits',255)->nullable();
	        $table->string('negatives',255)->nullable();
	        $table->integer('com')->nullable();
	        $table->integer('irr')->nullable();
	        $table->string('description',1000)->nullable();
        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    Schema::drop('ingredients');
	}

}
