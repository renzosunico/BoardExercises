<?php

class UserController extends AppController
{
	public function registration()
	{
		$page = Param::get('page_next','registration');
		$user = new User();

		switch($page) {
			case "registration":
				break;
			case "registration_end":
				$user->fname = Param::get('fname');
				$user->lname = Param::get('username');
				$user->username = Param::get('username');
				$user->email = Param::get('email');
				$user->password = Param::get('password');
				//$is_valid_username = $user->isValidUsername(Param::get('username'));
				try {
					$user->register($user);
				} catch (ValidationException $e) {
					$page = "registration";
				}
				break;
			default :
				throw new RecordNotFoundException('{$page} not found.');
				break;
		}

		$this->set(get_defined_vars());
		$this->render($page);
	}
}