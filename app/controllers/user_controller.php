<?php

class UserController extends AppController
{
	public function registration()
	{
		session_start();
		if(isset($_SESSION['username'])) {
			header('Location: thread/index');
		}
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

	public function login()
	{
		$user = new User();

		$clean_username = htmlentities(Param::get('username'));
		$clean_hashed_password = htmlentities(Param::get('password'));
		
		$page = Param::get('page_next','login');
		
		$isAuthorized = true;

		$message = array(
					'Welcome ',
					'Good To See You ',
					'Good Day ',
					'Hi-ya ',
					'Nice To See You ',
					'Hey ',
					'Hey Good Looking ',
					'What\'s Up '
					);
		$pickgreeting = rand(0,7);

		switch($page) {
			case "login":
				break;
			case "login_end":
				$user->username = $clean_username;
				$user->password = $clean_hashed_password;
				$isAuthorized = $user->isRegistered($user);
				
				if(!$isAuthorized)
				{
					$page = "login";
				}

				session_start();
				$_SESSION['username'] = $clean_username;
				
				break;
			default :
				throw new RecordNotFoundException;
				break;
		}
		$this->set(get_defined_vars());
		$this->render($page);
	}

	public function logout()
	{
		session_start();
		session_destroy();
		redirect('/user/login');
	}
}