<?php

class Dislikes extends Eloquent {

	protected $table = "dislikes";
	protected $guarded = ["id"];

	public function products()
    {
        return $this->belongsTo("Product");
    }
}