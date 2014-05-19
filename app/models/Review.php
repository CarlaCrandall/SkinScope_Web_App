<?php

class Review extends Eloquent {

	protected $table = "reviews";
	protected $hidden = ["id","product_id","user_id"];
	protected $guarded = ["id"];

	//validation rules for creating a new review
    public static $rules = array(
    	'review'=>'required|between:25,1000'  
    );


	/*
	|--------------------------------------------------------------------------
	| Review Relationships
	|--------------------------------------------------------------------------
	*/

	public function product()
    {
        return $this->belongsTo("Product");
    }

    public function user()
    {
        return $this->belongsTo("User");
    }


    /*
	|--------------------------------------------------------------------------
	| Review Functions
	|--------------------------------------------------------------------------
	*/

    //list product reviews
	public static function getReviews($id, $skintype){

		//start query - get reviews for specified product
		$query = Review::with('user')->where('product_id', $id);

		//if skin type is specified
		if($skintype != ''){

			//filer reviews based on user skin type
			$query->whereHas('user', function($subquery) use($skintype) {
	      		$subquery->where('skin_type', '=', $skintype);
			});	
		}

		//get data
		try{
			return $query->get();
		}
		//query failed
		catch(\Exception $e){
		    return "false";
		}
	}

	public static function createReview($id){

		//get user id and product id
		$userId = Auth::user()->id;
		$productId = $id;

		//create review
		$review = new Review();
		$review->user_id = $userId;
		$review->product_id = $productId;
		$review->review = Input::get('review');

		//save review
        try{
            return $review->save();
        }
        //save failed
        catch(\Exception $e){
            return false;
        }
	}


}