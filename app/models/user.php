<?php
class User extends AppModel
{
    public $validation = array(
        'fname'          => array(
            'length'     => array('validate_between', 1, 30),
            'alphachars' => array('validate_alpha')
        ),
        'lname'          => array(
            'length'     => array('validate_between', 1, 30),
            'alphachars' => array('validate_alpha'),
        ),
        'username'       => array(
            'length'     => array('validate_between', 6, 30),
            'chars'      => array('validate_chars'),
            'exist'      => array('validate_existence','username'),
        ),
        'email'          => array(
            'email'      => array('validate_email'),
            'exist'      => array('validate_existence','email'),
        ),
        'password'       => array(
            'length'     => array('validate_between', 6, 30),
            'chars' => array('validate_chars'),
        ),
    );

    public function register()
    {
        if(!$this->validate()) {
            throw new ValidationException('Invalid data.');
        }

        $params = array(
            'fname'    => $this->fname,
            'lname'    => $this->lname,
            'username' => $this->username,
            'email'    => $this->email,
            'password' => hash('sha1', $this->password)
            );

        $db = DB::conn();
        $db->insert('user',$params);
    }

    public static function isValidUsernameEmail($value, $type)
    {
        switch($type) {
            case "username" :
                if($value) {
                    $db = DB::conn();
                    return count($db->search('user','username=?',array($value))) == 0;
                }
                return false;
            case "email" :
                if($value) {
                    $db = DB::conn();
                    return count($db->search('user','email=?',array($value))) == 0;
                }
                return false;
        }
    }

    public function isRegistered()
    {
        $db = DB::conn();
        $row = $db->row("SELECT * FROM user WHERE username LIKE BINARY ? AND password LIKE BINARY ?", array($this->username, hash('sha1', $this->password)));
        
        return $row !== false;
    }
}