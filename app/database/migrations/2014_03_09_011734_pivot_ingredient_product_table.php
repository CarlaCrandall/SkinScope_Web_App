<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotIngredientProductTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ingredient_product', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('ingredient_id')->unsigned()->index();
			$table->foreign('ingredient_id')->references('id')->on('ingredients');
			$table->integer('product_id')->unsigned()->index();
			$table->foreign('product_id')->references('id')->on('products');
		});
	}



	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ingredient_product');
	}

}
