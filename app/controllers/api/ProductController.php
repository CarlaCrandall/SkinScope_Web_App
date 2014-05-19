<?php

class api_ProductController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| GET
	|--------------------------------------------------------------------------
	*/

	/**
	 * List product(s) based on query string parameters.
	 *
	 * @return Response
	 */
	public function index()
	{
		$input = Input::except('id');

		//if query string parameters exist
		if( count($input) > 0 ){

			//get products based on conditions
			$product = new Product();
			$result = $product->getProducts($input);
		}
		//if no query string parameters, get all products
		else{
			$result = Product::all();
		}

		//return products
		if($result != "false" && count($result) > 0){
			return Response::json($result, 200);
		}
		//return error
		else{
			return Response::json(array('error'=>'The URI requested is invalid or the resource requested does not exist.'), 404);
		}
	}


	/**
	 * Display the specified product.
	 *
	 * @return Response
	 */
	public function product($id)
	{
		$result = Product::find($id);

		//return product
		if(count($result) > 0){
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
	 * Store a newly created product.
	 *
	 * @return Response
	 */
	public function create()
	{
		//validate product data
		$validator = Validator::make(Input::all(), Product::$rules);
 	
 		//if validation passes, create product
	    if ($validator->passes()) {

	    	//create product
			$result = Product::createProduct();

			//if user creation was successful...
			if($result == false){
				return Response::json(array('error'=>'There was a problem creating the product'), 500);
			}
			//if there was an error creating the user...
			else{
				return Response::json(array('success'=>'The product has been created.'), 200);
			}

	    } 
	    // validation has failed, display error messages 
	    else{
	        return Response::json($validator->messages()->toArray(), 400);
	    }

	}

}
