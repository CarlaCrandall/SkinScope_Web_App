<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;


class User extends Eloquent implements UserInterface, RemindableInterface {

	protected $table = "users";
    protected $hidden = ["email","password"];
	protected $guarded = ["id","email","username","password"];

    //validation rules for creating a new user
    public static $rules = array(
        'first_name'=>'required|alpha|min:2',
        'last_name'=>'required|alpha|min:2',
        'email'=>'required|email|unique:users',
        'password'=>'required|alpha_num|between:6,12|confirmed',
        'password_confirmation'=>'required|alpha_num|between:6,12',
        'skin_type'=>'required|in:Normal,Oily,Dry,Sensitive,Combination',
        'photo_src'=>'max:2048|mimes:jpg,jpeg,png'
    );


    /*
    |--------------------------------------------------------------------------
    | User Relationships
    |--------------------------------------------------------------------------
    */

    public function reviews()
    {
        return $this->hasMany("Review");
    }

    public function products()
    {
        return $this->hasMany("Product");
    }


    /*
    |--------------------------------------------------------------------------
    | User Functions
    |--------------------------------------------------------------------------
    */

    //Get the unique identifier for the user.
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    //Get the password for the user.
    public function getAuthPassword()
    {
        return $this->password;
    }

    //Get the e-mail address where password reminders are sent.
    public function getReminderEmail()
    {
        return $this->email;
    }


    //create user and save to database
    public static function createUser(){
        //create username by combining first name and first letter of last name
        $username = Input::get('first_name') . " " . substr(Input::get('last_name'), 0, 1) . ".";

        $user = new User;
        $user->username = $username;
        $user->email = Input::get('email');
        $user->password = Hash::make(Input::get('password'));
        $user->skin_type = Input::get('skin_type');

        //if user uploaded a profile photo, include it
        if(Input::hasFile('photo_src')){

            //create random filename
            $filename = str_random(12) . '.' .Input::file('photo_src')->getClientOriginalExtension();

            //store image
            $upload_success = Input::file('photo_src')->move('images/uploads', $filename);
            
            //if successful
            if($upload_success) {
               $user->photo_src = 'images/uploads/' . $filename;
            } 
        }

        //save user
        try{
            return $user->save();
        }
        //save failed
        catch(\Exception $e){
            return false;
        }
    }
    
}