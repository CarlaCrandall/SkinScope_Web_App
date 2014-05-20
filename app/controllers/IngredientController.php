<?php

class IngredientController extends api_IngredientController {

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
	public function ingredients($id)
	{
		//get product info
		$request = Request::create('api/products/' . $id, 'GET');
		$product = Route::dispatch($request)->getData();

		//call index function of api controller to get products
		$response =  $this->productIngredients($id)->getData();

		//list of all ingredient ratings
		$ratings = ['All Ratings','Good','Average','Poor','Unknown'];

		//if product exists
		if(!array_key_exists('error', $product)){

			//if ingredients exist
			if(!array_key_exists('error', $response)){
				
				//return ingredients to the view
	        	return View::make('ingredients')->with('product', $product)->with('ingredients', $response)->with('ratings', $ratings);
			}
			else{
				//else create view without ingredients
	        	return View::make('ingredients')->with('product', $product)->with('ratings', $ratings);
			}
		}
		else{
			//else create view without product
	        return View::make('ingredients');
		}

			
	}

}
