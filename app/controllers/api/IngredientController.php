<?php

class api_IngredientController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| GET
	|--------------------------------------------------------------------------
	*/

	/**
	 * List all ingredient(s).
	 *
	 * @return Response
	 */
	public function index()
	{
		$result = Ingredient::all();

		//return ingredients
		if($result != "false" && count($result) > 0){
			return Response::json($result, 200);
		}
		//return error
		else{
			return Response::json(array('error'=>'The URI requested is invalid or the resource requested does not exist.'), 404);
		}
		
	}


	/**
	 * Display the specified ingredient.
	 *
	 * @return Response
	 */
	public function ingredient($id)
	{
		$result = Ingredient::find($id);

		//return ingredient
		if(count($result) > 0){
			return Response::json($result, 200);
		}
		//return error
		else{
			return Response::json(array('error'=>'The URI requested is invalid or the resource requested does not exist.'), 404);
		}
		
	}


	/**
	 * Display ingredients for the specified product.
	 *
	 * @return Response
	 */
	public function productIngredients($id)
	{
		//if ingredient rating is specified
		if( Input::has('rating') ){
			//get ingredients based on rating
			$result = Ingredient::getIngredients($id, Input::get('rating'));
		}
		else{
			//if no rating is specified, get all ingredients
			$result = Ingredient::getIngredients($id, '');
		}

		//return ingredients
		if($result != false && count($result) > 0){
			return Response::json($result, 200);
		}
		//return error
		else{
			return Response::json(array('error'=>'The URI requested is invalid or the resource requested does not exist.'), 404);
		}
	}


}
