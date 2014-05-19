<?php 

class CustomHasher implements Illuminate\Hashing\HasherInterface {

	//Hashes value using sha512 and salt
	public function make($value, array $options = array())
	{
		$salt = "d46bc82855ceb3a3d2f796a7534ce774";
    	return hash("sha512", $salt.$value);
	}

	//Checks the given plain value against a hash.
	public function check($value, $hashedValue, array $options = array())
	{
		$salt = "d46bc82855ceb3a3d2f796a7534ce774";
		return $hashedValue === hash("sha512", $salt.$value);
	}

	public function needsRehash($hashedValue, array $options = array())
	{
		return true;
	}

}
