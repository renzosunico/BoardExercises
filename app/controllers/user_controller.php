<?php
class UserController extends AppController
{
    public function registration()
    {
        if(isset($_SESSION['username'])) {
            redirect('thread/index');
        }

        $page = Param::get('page_next','registration');
        $user = new User();

        switch($page) {
            case "registration":
                break;
            case "registration_end":
                $user->fname = Param::get('fname');
                $user->lname = Param::get('lname');
                $user->username = Param::get('username');
                $user->email = Param::get('email');
                $user->password = Param::get('password');
                try {
                    $user->register();
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

        switch($page) {
            case "login":
                break;
            case "login_end":
                $user->username = $clean_username;
                $user->password = $clean_hashed_password;
                $isAuthorized = $user->isRegistered($user);
                
                if(!$isAuthorized) {
                    $page = "login";
                } else {
                    $_SESSION['username'] = $clean_username;
                }
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
        session_destroy();
        redirect('user/login');
    }
}