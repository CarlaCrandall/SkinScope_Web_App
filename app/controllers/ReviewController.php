<?php

class ReviewController extends api_ReviewController {

	/*
	|--------------------------------------------------------------------------
	| GET
	|--------------------------------------------------------------------------
	*/

	/**
	 * Display ingredients for the specified product.
	 *
	 * @return Response
	 */
	public function reviews($id)
	{
		//get product info
		$request = Request::create('api/products/' . $id, 'GET');
		$product = Route::dispatch($request)->getData();

		//call productIngredients function of api controller to get ingredients
		$response =  $this->productReviews($id)->getData();

		//list of all ingredient ratings
		$skinTypes = ['All Skin Types','Normal','Oily','Dry','Sensitive','Combination'];

		//if product exists
		if(!array_key_exists('error', $product)){

			//if reviews exist
			if(!array_key_exists('error', $response)){
				
				//return reviews to the view
	        	return View::make('reviews')->with('product', $product)->with('reviews', $response)->with('skinTypes', $skinTypes);
			}
			else{
				//else create view without reviews
	        	return View::make('reviews')->with('product', $product)->with('skinTypes', $skinTypes);
			}
		}
		else{
			//else create view without product
	        return View::make('reviews');
		}			
	}

}
