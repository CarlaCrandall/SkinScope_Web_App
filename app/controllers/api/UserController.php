<?php

class api_UserController extends BaseController {


	/*
	|--------------------------------------------------------------------------
	| POST
	|--------------------------------------------------------------------------
	*/

	/**
	 * Store a newly created user.
	 *
	 * @return Response
	 */
	public function create()
	{
		//validate user data
		$validator = Validator::make(Input::all(), User::$rules);
 	
 		//if validation passes, create user
	    if ($validator->passes()) {

	    	//create user
			$result = User::createUser();

			//if user creation was successful...
			if($result != false){
				return Response::json(array('success'=>'The user has been created.'), 200);
			}
			//if there was an error creating the user...
			else{
				return Response::json(array('error'=>'There was a problem creating the user.'), 500);
			}

	    } 
	    // validation has failed, display error messages 
	    else{
	        return Response::json($validator->messages()->toArray(), 400);
	    }
	}


	/*
	|--------------------------------------------------------------------------
	| GET
	|--------------------------------------------------------------------------
	*/

	/**
	 * Test user credentials.
	 *
	 * @return Response
	 */
	public function auth()
	{
		return Response::json(array('success'=>'User credentials are valid.'), 200);	
	}

}
