<?php

class Ingredient extends Eloquent {

	protected $table = "ingredients";
	protected $hidden = ["pivot"];
	protected $guarded = ["id"];

	//validation rules for creating a new ingredient
    public static $rules = array(
        'name'=>'required|min:2',
        'function'=>'optional|alpha|min:2',
        'benefits'=>'optional|alpha|min:2',
        'negatives'=>'optional|alpha|min:2',
        'com'=>'optional|in:0,1,2,3,4,5',
        'irr'=>'optional|in:0,1,2,3,4,5',
        'description'=>'optional|alpha|min:2',
    );


	/*
	|--------------------------------------------------------------------------
	| Ingredient Relationships
	|--------------------------------------------------------------------------
	*/

	public function products()
    {
        return $this->belongsToMany("Product", "ingredient_product", "ingredient_id", "product_id");
    }


    /*
	|--------------------------------------------------------------------------
	| Ingredient Functions
	|--------------------------------------------------------------------------
	*/

	//list ingredients for specified product
	public static function getIngredients($id, $rating){

		//create query - get all ingredients belonging to product
		$query = Ingredient::whereHas('products', function($subquery) use($id) {
      		$subquery->where('products.id', '=', $id);
		});	

		//filter ingredients by rating, if specified
		if($rating != ''){
			$query->where('rating', $rating);
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


	//create ingredient and save to database
	public static function createIngredient($name, $function=null, $benefits=null, $negatives=null, $com=null, $irr=null, $description=null){

		//used to calculate ingredient rating
		$ratingCalc = 0;
		$rating = "Unknown";

		//create new ingredient
		$ingredient = new Ingredient;
		$ingredient->name = $name;

		//if function is provided, add it to the ingredient
		if($function != null){
			$ingredient->function = $function;
		}

		//if benefits are provided, add it to them ingredient
		if($benefits != null){
			$ingredient->benefits = $benefits;
			$ratingCalc -= 2; //adjust ingredient rating, if provides benefits
			$rating = '';
		}

		//if negatives are provided, add it to them ingredient
		if($negatives != null){
			$ingredient->negatives = $negatives;
			$ratingCalc += 2; //adjust ingredient rating, if provides negatives
			$rating = '';
		}

		//if comedogenicity rating is provided, add it to the ingredient
		if($com != null){
			$ingredient->com = $com;
			$ratingCalc += $com;
			$rating = '';
		}

		//if irritancy rating is provided, add it to the ingredient
		if($irr != null){
			$ingredient->irr = $irr;
			$ratingCalc += $irr;
			$rating = '';
		}

		//if description is provided, add it to the ingredient
		if($description != null){
			$ingredient->description = $description;
		}

		//figure out ingredient rating
		if($rating != "Unknown"){
			if($ratingCalc < 4){ $ingredient->rating = "Good"; } //low numbers = good rating
			else if($ratingCalc > 7){ $ingredient->rating = "Poor"; } //high numbers = bad rating
			else{ $ingredient->rating = "Average"; } 
		}
		else{
			$ingredient->rating = "Unknown"; //if data is not present, rating cannot be calculated
		}

		//save user
        try{
            $ingredient->save();
            return $ingredient->id;
        }
        //save failed
        catch(\Exception $e){
            return false;
        }

	}


}