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

		//call productIngredients function of api controller to get ingredients
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


	/**
	 * Display info for the specified ingredient
	 *
	 * @return Response
	 */
	public function ingredientById($productId, $ingredientId)
	{
		//get product info
		$request = Request::create('api/products/' . $productId, 'GET');
		$product = Route::dispatch($request)->getData();

		//get product ingredients
		$ingredients = $this->productIngredients($productId)->getData();

		//call ingredient function of api controller to get ingredient
		$response =  $this->ingredient($ingredientId)->getData();

		//if product exists
		if(!array_key_exists('error', $product)){

			//if ingredients exist
			if(!array_key_exists('error', $ingredients)){

				//if ingredient exists
				if(!array_key_exists('error', $response)){
					
					//return ingredient to the view
		        	return View::make('ingredient')->with('product', $product)->with('ingredient', $response)->with('ingredients', $ingredients);
				}
				else{

					//else create view without ingredient
		        	return View::make('ingredient')->with('product', $product)->with('ingredients', $ingredients);
				}
			}
			else{

				//else create view without ingredients
		        return View::make('ingredient')->with('product', $product);
			}

			
		}
		else{
			//else create view without product
	        return View::make('ingredient');
		}
	}


}
