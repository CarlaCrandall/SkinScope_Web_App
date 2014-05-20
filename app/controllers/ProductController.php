<?php

class ProductController extends api_ProductController {

	/*
	|--------------------------------------------------------------------------
	| GET
	|--------------------------------------------------------------------------
	*/

	/**
	 * List products based on chosen criteria
	 *
	 * @return Response
	 */
	public function products()
	{
		//list of all product categories
		$categories = ['Cleanser','Toner','Makeup Remover','Exfoliant','Moisturizer','Sunscreen','Serum','Mask','Eye Care','Lip Care','Body Care'];

		//list of all product ratings
		$ratings = ['All Ratings','Good','Average','Poor','Unknown'];

		//call index function of api controller to get products
		$response =  $this->index()->getData();

		//if products exist
		if(!array_key_exists('error', $response)){
			
			//return products to the view
        	return View::make('products')->with('products', $response)->with('categories', $categories)->with('ratings', $ratings);
		}
		else{
			//else create view without products
        	return View::make('products')->with('categories', $categories)->with('ratings', $ratings);
		}		
	}


	/**
	 * Show single product by id
	 *
	 * @return Response
	 */
	public function productById($id)
	{
		//call index function of api controller to get products
		$response =  $this->product($id)->getData();

		//if product exists
		if(!array_key_exists('error', $response)){
			
			//return product to the view
        	return View::make('product')->with('product', $response);
		}
		else{
			//else create view without product
			return View::make('product');
		}
	}

}
