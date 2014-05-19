<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::rename('likedProducts', 'likes');
		Schema::rename('dislikedProducts', 'dislikes');
		Schema::rename('wishlistedProducts', 'wishlists');
		Schema::rename('blacklistedIngredients', 'blacklists');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
