<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateProductTable2 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('', function(Blueprint $table) {
			$table->engine = 'MyISAM';
		});

	    DB::statement('ALTER TABLE products ADD FULLTEXT search(name, brand)');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('');
	}

}
