<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('products', function(Blueprint $table) {
            $table->increments('id');
            $table->string('upc',12);
	        $table->string('name',255);
	        $table->string('brand',100);
	        $table->string('category',35);
	        $table->string('rating',10);
        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    Schema::drop('products');
	}

}
