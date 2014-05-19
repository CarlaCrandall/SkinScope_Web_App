<?php

class Product extends Eloquent {

	protected $table = "products";
	protected $hidden = ["user_id"];
	protected $appends = ["numIngredients","numComedogenics","numIrritants","numReviews","numLikes","numDislikes"];
	protected $guarded = ["id"];

	//validation rules for creating a new product
    public static $rules = array(
        'name'=>'required|min:2',
        'brand'=>'required|min:2',
        'category'=>'required|in:Cleanser,Toner,Makeup Remover,Exfoliant,Moisturizer,Sunscreen,Serum,Mask,Eye Care,Lip Care,Body Care',
        'ingredients'=>'required|array',
        'upc'=>'digits:12'
    );


	/*
	|--------------------------------------------------------------------------
	| Product Relationships
	|--------------------------------------------------------------------------
	*/

	public function ingredients()
    {
        return $this->belongsToMany("Ingredient", "ingredient_product", "product_id", "ingredient_id");
    }

    public function reviews()
    {
        return $this->hasMany("Review");
    }

    public function likes()
    {
        return $this->hasMany("Likes");
    }

    public function dislikes()
    {
        return $this->hasMany("Dislikes");
    }

    public function user()
    {
    	return $this->belongsTo('User');
    }


    /*
	|--------------------------------------------------------------------------
	| Custom Product Attributes
	|--------------------------------------------------------------------------
	*/

    //return number of product ingredients
	public function getNumIngredientsAttribute()
	{
	    return $this->ingredients()->count();
	}

	//return number of product comedogenics
	public function getNumComedogenicsAttribute()
	{
		return $this->ingredients()->where('com', '>', 2)->count();
	}

	//return number of product irritants
	public function getNumIrritantsAttribute()
	{
	    return $this->ingredients()->where('irr', '>', 2)->count();
	}

	//return number of product reviews
	public function getNumReviewsAttribute()
	{
	    return $this->reviews()->count();
	}

	//return number of product likes
	public function getNumLikesAttribute()
	{
	    return $this->likes()->count();
	}

	//return number of product dislikes
	public function getNumDislikesAttribute()
	{
	    return $this->dislikes()->count();
	}


	/*
	|--------------------------------------------------------------------------
	| Product Functions
	|--------------------------------------------------------------------------
	*/

	//list products based on conditions
	public function getProducts($conditions){

		//start the query
		$query = Product::query();

		//if name and brand are equal, use advanced where clause (handles iPhone search calls)
		if(Input::get('name') == Input::get('brand')){

			$searchTerm = "%" . Input::get('name') . "%";

			$query->orWhere(function($query) use ($searchTerm){
			    
			    $query->orWhere('name','LIKE',$searchTerm);
                $query->orWhere('brand','LIKE',$searchTerm);

			});
			
            foreach($conditions as $key => $value){

            	if($key != "name" && $key != "brand"){
            		$query->where($key,$value);
            	}
            }
            
		}
		//else, build standard query (handles web app calls)
		else{

			//loop through conditions, build query
			foreach($conditions as $key => $value){

				//list products by name (accepts partial values)
				if($key == "name" || $key == "brand"){
					$searchTerm = "%" . $value . "%";
					$query->where($key,'LIKE',$searchTerm);
				}
				//list products by criteria (rating, category)
				else{
					$query->where($key,$value);
				}
			}
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


	//create product and save to database
	public static function createProduct(){

		//used to calculate product rating
		$ingredients = Input::get('ingredients');
		$ingredientRatings = array('good'=>0, 'average'=>0, 'poor'=>0, 'unknown'=>0);
		
		$ingredientIds = array();

		//loop through all ingredients
		foreach ($ingredients as $ingredient) {
			
			//if ingredient is in the database...
			if($result = DB::table('ingredients')->where('name', $ingredient)->first()){
				
				//check and store ingredient rating
				if($result->rating == "Good"){
					$ingredientRatings['good'] = $ingredientRatings['good'] + 1;
				}
				else if($result->rating == "Average"){
					$ingredientRatings['average'] = $ingredientRatings['average'] + 1;
				}
				else if($result->rating == "Poor"){
					$ingredientRatings['poor'] = $ingredientRatings['poor'] + 1;
				}
				else if($result->rating == "Unknown"){
					$ingredientRatings['unknown'] = $ingredientRatings['unknown'] + 1;
				}

				//store ingredient id - used to update pivot table
				array_push($ingredientIds, $result->id);

			}
			//if ingredient is not in the database
			else{

				//validate ingredient data
				$validator = Validator::make(array('name'=>$ingredient), Ingredient::$rules);
				
				//if validator passes, add ingredient to database
				if ($validator->passes()) {
					$result = Ingredient::createIngredient($ingredient);

					//get new ingredient id - used to update pivot table
					if($result != false){
						array_push($ingredientIds, $result);
					}

					//only data we have is the ingredient name, so rating is unknown
					$ingredientRatings['unknown'] = $ingredientRatings['unknown'] + 1;
				}

			}
		}

		//get number of ingredients in product
		$totalIngredients = count($ingredients);
		
		//if more than half of the ingredients are unknown, set product rating to unknown
		if($ingredientRatings['unknown'] >= $totalIngredients/2){
			$productRating = 'Unknown';
		}
		//else, calculate the product rating
		else{
			
			//weighted average based on ingredient ratings
			$avg = (3*$ingredientRatings['good'] + 2*$ingredientRatings['average'] + $ingredientRatings['poor']) / ($ingredientRatings['good'] + $ingredientRatings['average'] + $ingredientRatings['poor']);
 	
 			//if avg is low, rating is poor
			if($avg >= 1 && $avg < 1.6){
				$productRating = 'Poor';
			}
			//if avg is med, rating is average
			else if($avg >= 1.6 && $avg < 2.3){
				$productRating = 'Average';
			}
			//if avg is high, rating is good
			else{
				$productRating = 'Good';
			}
		}

		//create product
		$product = new Product;
		$product->user_id = Auth::user()->id; //store the id of the user that created the product
        $product->name = Input::get('name');
        $product->brand = Input::get('brand');
        $product->rating = $productRating;		
        $product->category = Input::get('category');

        //if upc is included, add it to the product
        if(Input::has('upc')){
        	$product->upc = Input::get('upc');
        }

        
        try{
            $result = $product->save(); //save product
            $product->ingredients()->sync($ingredientIds); //update ingredient_product pivot table
            
            return $result;
        }
        //save failed
        catch(\Exception $e){
            return false;
        }
	
	}


}