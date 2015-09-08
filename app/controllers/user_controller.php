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
                $user->confirmpassword = Param::get('repassword');
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
                $isAuthorized = $user->isRegistered();
                
                if(!$isAuthorized) {
                    $page = "login";
                } else {
                    $_SESSION['username'] = $clean_username;
                    $_SESSION['userid'] = User::getIdByUsername($clean_username);
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

    public function profile()
    {
        $user = new User();
        $user->id = Param::get('user_id');
        $user->getProfile();

        if(!isset($user->username)) {
            redirect('notfound/pagenotfound');
        }

        $threads_followed = array();
        $thread_followed_id = Follow::getFollowedThreadIds($user->id);

        foreach($thread_followed_id as $thread) {
            $threads_followed[] = Thread::getById($thread['thread_id']);
        }

        foreach ($threads_followed as $thread) {
            $thread->username = User::getUsernameById($thread->user_id);
        }

        $threads_created = Thread::getByUserId($user->id);

        foreach ($threads_created as $thread) {
            $thread->username = User::getUsernameById($thread->user_id);
        }

        $this->set(get_defined_vars());
    }

    public function edit()
    {
        $process = Param::get('process', 'edit');

        switch($process) {
            case 'account':
                unset($user);
                $user = new User();
                $user->id = $_SESSION['userid'];
                $user->fname = Param::get('firstname');
                $user->lname = Param::get('lastname');
                $user->new_username = Param::get('username');
                $user->new_email = Param::get('email');
                try {
                    $user->updateAccount();
                    $_SESSION['username'] = $user->new_username;
                    $user->editSuccess = true; 
                } catch(ValidationException $e) {

                }
                break;
            case 'profile':
                unset($user);
                $user = new User();
                $user->id = $_SESSION['userid'];
                $user->company = Param::get('company');
                $user->division = Param::get('division');
                $user->specialization = Param::get('specialization');
                try {
                    $user->updateProfile();
                    $user->editSuccess = true;
                } catch(ValidationException $e) {

                }
                break;
            case 'password':
                unset($user);
                $user = new User();
                $user->id = $_SESSION['userid'];

                //set username and old password to password
                //property to authenticate user
                $user->username = $_SESSION['username'];
                $user->password = htmlentities(Param::get('oldPassword'));

                if(!$user->isRegistered()) {
                    $user->notAuthorized = true;
                    break;
                }
                //Unset username so it won't be included in validation
                unset($user->username);
                $user->password = htmlentities(Param::get('password'));
                $user->confirmpassword = htmlentities(Param::get('confirmPassword'));

                try {
                    $user->updatePassword();
                    $user->editSuccess = true;
                } catch (ValidationException $e) {

                }
                break;
            case 'edit':
                $user = new User();
                $user->id = $_SESSION['userid'];
                break;
        }
        
        $user->getProfile();
        $this->set(get_defined_vars());
    }
}