<?php
class User extends AppModel
{
    public $name="dasd";
    public $validation = array(
        'fname'           => array(
            'length'      => array('validate_between', 1, 30),
            'alphachars'  => array('validate_alpha'),
        ),
        'lname'           => array(
            'length'      => array('validate_between', 1, 30),
            'alphachars'  => array('validate_alpha'),
        ),
        'username'        => array(
            'length'      => array('validate_between', 6, 30),
            'chars'       => array('validate_chars'),
            'exist'       => array('validate_existence', 'username'),
        ),
        'email'           => array(
            'email'       => array('validate_email'),
            'exist'       => array('validate_existence', 'email'),
        ),
        'password'        => array(
            'length'      => array('validate_between', 6, 30),
            'chars'       => array('validate_chars'),
        ),
        'confirmpassword' => array(
            'confirm'     => array('confirm_password'),
        )
    );

    public function register()
    {
        if(!$this->validate()) {
            throw new ValidationException('Invalid data.');
        }

        $password = hash_password($this->password);

        $params = array(
            'fname'    => $this->fname,
            'lname'    => $this->lname,
            'username' => $this->username,
            'email'    => $this->email,
            'password' => $password['hash'],
            'salt'     => $password['salt'],
        );

        $db = DB::conn();
        $db->insert('user',$params);
    }

    public static function isValidUsernameEmail($value, $type)
    {
        $db = DB::conn();
        switch($type) {
            case "username" :
                if($value) {
                    return count($db->search('user','username=?',array($value))) == 0;
                }
                return false;
            case "email" :
                if($value) {
                    return count($db->search('user','email=?',array($value))) == 0;
                }
                return false;
        }
    }

    public function isRegistered()
    {
        $db = DB::conn();
        $result = $db->row("SELECT password, salt FROM user WHERE username LIKE BINARY ?", array($this->username));

        if(crypt($this->password, '$2a$11$' . $result['salt']) === $result['password']) {
            return true;
        }
        return false;
    }

    public static function getIdByUsername($username)
    {
        $db = DB::conn();
        return $db->value("SELECT id FROM user where username = ?", array($username));
    }

    public static function getUsernameById($user_id)
    {
        $db = DB::conn();
        return $db->value("SELECT username FROM user WHERE id = ?", array($user_id));
    }

    public function getProfile()
    {
        $db = DB::conn();
        $user_info = $db->row("SELECT fname, lname, username, company, division, specialization
                               FROM user
                               WHERE id = ?", array($this->id));

        if($db->rowCount() != 0) {
            $this->set($user_info);
        }
    }
}