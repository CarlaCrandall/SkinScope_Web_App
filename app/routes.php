<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


//home redirects to the product list
Route::get('/', function(){
    return Redirect::to('/products');
});

//get product(s) based on criteria
Route::get('/products', [
    "uses" => "ProductController@products"
]);

//get product by ID
Route::get("/products/{id}", [
    "uses" => "ProductController@productById"
]);

//get product ingredients
Route::get("/products/{id}/ingredients", [
    "uses" => "IngredientController@ingredients"
]);

//get ingredient by ID
Route::get("/products/{productId}/ingredients/{ingredientId}", [
    "uses" => "IngredientController@ingredientById"
]);

//get product reviews
Route::get("/products/{id}/reviews", [
    "uses" => "ReviewController@reviews"
]);



/*
|--------------------------------------------------------------------------
| API User Routes
|--------------------------------------------------------------------------
*/

//create a new user
Route::post("api/users/create", [
    "uses" => "api_UserController@create"
]);

//create a new product review
Route::get("api/users/auth", [
    "before" => "auth.api",
    "uses" => "api_UserController@auth"
]);


/*
|--------------------------------------------------------------------------
| API Product Routes
|--------------------------------------------------------------------------
*/

//get product(s)
Route::get("api/products", [
    "uses" => "api_ProductController@index"
]);

//get specified product
Route::get("api/products/{id}", [
    "uses" => "api_ProductController@product"
]);

//create a new product
Route::post("api/products/create", [
    "before" => "auth.api",
    "uses" => "api_ProductController@create"
]);


/*
|--------------------------------------------------------------------------
| API Review Routes
|--------------------------------------------------------------------------
*/

//get specified product's reviews
Route::get("api/products/{id}/reviews", [
    "uses" => "api_ReviewController@productReviews"
]);

//create a new product review
Route::post("api/products/{id}/reviews/create", [
    "before" => "auth.api",
    "uses" => "api_ReviewController@create"
]);


/*
|--------------------------------------------------------------------------
| API Ingredient Routes
|--------------------------------------------------------------------------
*/

//get all ingredient
Route::get("api/ingredients", [
    "uses" => "api_IngredientController@index"
]);

//get specified ingredient
Route::get("api/ingredients/{id}", [
    "uses" => "api_IngredientController@ingredient"
]);

//get specified product's ingredients
Route::get("api/products/{id}/ingredients", [
    "uses" => "api_IngredientController@productIngredients"
]);
