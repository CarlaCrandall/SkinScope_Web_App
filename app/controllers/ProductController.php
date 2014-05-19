<?php

class ProductController extends api_ProductController {

	/*
	|--------------------------------------------------------------------------
	| GET
	|--------------------------------------------------------------------------
	*/

	/**
	 * List products 
	 *
	 * @return Response
	 */
	public function showProducts()
	{
		//call index function of api controller to get products
		$response =  $this->index();

		//list of all product categories
		$categories = ['Cleanser','Toner','Makeup Remover','Exfoliant','Moisturizer','Sunscreen','Serum','Mask','Eye Care','Lip Care','Body Care'];

		//list of all product ratings
		$ratings = ['Good','Average','Poor','Unknown'];

		//return products to the view
        return View::make('hello')->with('products', $response->getData())->with('categories', $categories)->with('ratings', $ratings);

	}

}
