<?php

class Likes extends Eloquent {

	protected $table = "likes";
	protected $guarded = ["id"];

	public function products()
    {
        return $this->belongsTo("Product");
    }
}