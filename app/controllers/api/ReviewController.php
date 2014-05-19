<?php

class api_ReviewController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| GET
	|--------------------------------------------------------------------------
	*/

	/**
	 * Display reviews for the specified product.
	 *
	 * @return Response
	 */
	public function productReviews($id)
	{
		//if skin type is specified
		if(Input::get('skin_type')){
			//get reviews based on skin type
			$result = Review::getReviews($id, Input::get('skin_type'));
		}
		else{
			//if no skin type is specified, get all reviews
			$result = Review::getReviews($id, '');
		}

		//return reviews
		if($result != false && count($result) > 0){
			return Response::json($result, 200);
		}
		//return error
		else{
			return Response::json(array('error'=>'The URI requested is invalid or the resource requested does not exist.'), 404);
		}
	}

	/*
	|--------------------------------------------------------------------------
	| POST
	|--------------------------------------------------------------------------
	*/

	/**
	 * Store a newly created review.
	 *
	 * @return Response
	 */
	public function create($id)
	{
		//validate data
		$validator = Validator::make(Input::only('review'), Review::$rules);

		//if validation passes, create review
	    if ($validator->passes()) {

	    	//create user
			$result = Review::createReview($id);

			//if review creation was successful...
			if($result != false){
				return Response::json(array('success'=>'The review has been submitted.'), 200);
			}
			//if there was an error creating the user...
			else{
				return Response::json(array('error'=>'There was a problem submitting the review.'), 500);
			}

	    } 
	    // validation has failed, display error messages 
	    else{
	        return Response::json($validator->messages()->toArray(), 400);
	    }
	}

}
