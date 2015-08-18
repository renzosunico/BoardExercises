<?php

class User extends AppModel
{
	public $validation = array(
		'fname' => array(
			'length' => array(
				'validate_between',1,30),
			'alphachars' => array(
				'validate_alpha')
			),
		'lname' => array(
			'length' => array(
				'validate_between',1,30),
			'alphachars' => array(
				'validate_alpha'),
			),
		'username' => array(
			'length' => array(
				'validate_between',6,30),
			'chars' => array(
				'validate_chars'),
			'exist' => array(
				'validate_existence','username'),
			),
		'email' => array(
			'email' => array(
				'validate_email'),
			'exist' => array(
				'validate_existence','email'),
			),
		'password' => array(
			'length' => array(
				'validate_between',6,30),
			'chars' => array(
				'validate_chars'),
			),
		);

	public function register(User $user)
	{
		if(!$user->validate()) {
			throw new ValidationException('Invalid data.');
		}

		$db = DB::conn();
		$db->query(
			"INSERT INTO user SET fname=?, lname=?, username=?, email=?, password=?",
			array($user->fname, $user->lname, $user->username, $user->email, $user->password));
	}

	public static function isValidUsername($value, $type)
	{
		switch($type) {
			case "username" :
				if($value) {
					$db = DB::conn();
					return count($db->search('user','username=?',array($value))) == 0;
				}
				else {
					return false;
				}
				break;
			case "email" :
				if($value) {
					$db = DB::conn();
					return count($db->search('user','email=?',array($value))) == 0;
				}
				else {
					return false;
				}
				break;
		}
	}
}