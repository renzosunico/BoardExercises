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

    CONST START_RAND_NO = 0;
    CONST END_RAND_NO = 7;

    public function register(User $user)
    {
        if(!$user->validate()) {
            throw new ValidationException('Invalid data.');
        }

        $db = DB::conn();
        $db->query(
            "INSERT INTO user SET fname=?, lname=?, username=?, email=?, password=?",
            array($user->fname, $user->lname, $user->username, $user->email, hash('sha1', $user->password)));
    }

    public static function is_valid_username_email($value, $type)
    {
        if(empty($value)) {
            return true;
        }
        switch($type) {
            case "username" :
                if($value) {
                    $db = DB::conn();
                    return count($db->search('user','username=?',array($value))) == 0;
                } else {
                    return false;
                }
                break;
            case "email" :
                if($value) {
                    $db = DB::conn();
                    return count($db->search('user','email=?',array($value))) == 0;
                } else {
                    return false;
                }
                break;
        }
    }

    public function is_registered(User $user)
    {
        $db = DB::conn();
        $row = $db->row("SELECT * FROM user WHERE username LIKE BINARY ? AND password LIKE BINARY ?", array($user->username, hash('sha1', $user->password)));
        
        return $row !== false;
    }

    public function get_welcome_message()
    {
       $welcome_messages = array(
                    'Welcome ',
                    'Good To See You ',
                    'Good Day ',
                    'Hi-ya ',
                    'Nice To See You ',
                    'Hey ',
                    'Hey Good Looking ',
                    'What\'s Up '
                    );

       return $welcome_messages[rand(self::START_RAND_NO, self::END_RAND_NO)];
    }
}