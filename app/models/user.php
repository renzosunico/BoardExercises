<?php
class User extends AppModel
{
    CONST MIN_FIRST_NAME_LEGTH      = 1;
    CONST MAX_FIRST_NAME_LENGTH     = 30;
    CONST MIN_LAST_NAME_LEGTH       = 1;
    CONST MAX_LAST_NAME_LENGTH      = 30;
    CONST MIN_USERNAME_LEGTH        = 6;
    CONST MAX_USERNAME_LENGTH       = 30;
    CONST MIN_PASSWORD_LEGTH        = 6;
    CONST MAX_PASSWORD_LENGTH       = 30;
    CONST MIN_COMPANY_LEGTH         = 1;
    CONST MAX_COMPANY_LENGTH        = 60;
    CONST MIN_DIVISION_LEGTH        = 1;
    CONST MAX_DIVISION_LENGTH       = 30;
    CONST MIN_SPECIALIZATION_LEGTH  = 1;
    CONST MAX_SPECIALIZATION_LENGTH = 30;
    CONST TYPE_EMAIL                = 'email';
    CONST TYPE_USERNAME             = 'username';
    CONST HASH_TYPE                 = '$2a$11$';
    CONST TABLE_NAME                     = 'user';

    public $validation = array(
        'fname'           => array(
            'length'      => array('validate_between', self::MIN_FIRST_NAME_LEGTH, self::MAX_FIRST_NAME_LENGTH),
            'alphachars'  => array('validate_alpha'),
        ),
        'lname'           => array(
            'length'      => array('validate_between', self::MIN_LAST_NAME_LEGTH, self::MAX_LAST_NAME_LENGTH),
            'alphachars'  => array('validate_alpha'),
        ),
        'username'        => array(
            'length'      => array('validate_between', self::MIN_USERNAME_LEGTH, self::MAX_USERNAME_LENGTH),
            'chars'       => array('validate_chars'),
            'exist'       => array('validate_existence', 'username'),
        ),
        'email'           => array(
            'email'       => array('validate_email'),
            'exist'       => array('validate_existence', 'email'),
        ),
        'password'        => array(
            'length'      => array('validate_between', self::MIN_PASSWORD_LEGTH, self::MAX_PASSWORD_LENGTH),
            'chars'       => array('validate_chars'),
        ),
        'confirmpassword' => array(
            'confirm'     => array('confirm_password'),
        ),
        'new_username'    => array(
            'exist'       => array('validate_changes', 'username'),
        ),
        'new_email'       => array(
            'exist'       => array('validate_changes', 'email'),
        ),
        'company'         => array(
            'alphachars'  => array('validate_alpha'),
            'length'      => array('validate_between', self::MIN_COMPANY_LEGTH, self::MAX_COMPANY_LENGTH),
        ),
        'division'        => array(
            'alphachars'  => array('validate_alpha'),
            'length'      => array('validate_between', self::MIN_DIVISION_LEGTH, self::MAX_DIVISION_LENGTH),
        ),
        'specialization'  => array(
            'alphachars'  => array('validate_alpha'),
            'length'      => array('validate_between', self::MIN_SPECIALIZATION_LEGTH, self::MAX_SPECIALIZATION_LENGTH),
        ),
    );

    public function register()
    {
        $this->validate();
        
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
        $db->insert('user', $params);
    }

    public static function isValidUsernameEmail($value, $type)
    {
        $db = DB::conn();
        switch($type) {
            case self::TYPE_USERNAME:
                if($value) {
                    return count($db->search(self::TABLE_NAME, 'username=?', array($value))) == 0;
                }
            case self::TYPE_EMAIL:
                if($value) {
                    return count($db->search(self::TABLE_NAME, 'email=?', array($value))) == 0;
                }
        }

        return false;
    }

    public function isRegistered()
    {
        $db = DB::conn();
        $result = $db->row("SELECT password, salt FROM user WHERE username LIKE BINARY ?", array($this->username));

        if(crypt($this->password, self::HASH_TYPE . $result['salt']) === $result['password']) {
            return true;
        }
        return false;
    }

    public static function getIdByUsername($username)
    {
        $db = DB::conn();
        return $db->value("SELECT id FROM user WHERE username = ?", array($username));
    }

    public static function getUsernameById($user_id)
    {
        $db = DB::conn();
        return $db->value("SELECT username FROM user WHERE id = ?", array($user_id));
    }

    public function getProfile()
    {
        $db = DB::conn();
        $user_info = $db->row("SELECT fname, lname, username, company, division, specialization, email
                               FROM user
                               WHERE id = ?", array($this->id));
        if($user_info) {
            $this->set($user_info);
        }
    }

    public function isUser($session_user)
    {
        return $this->id === $session_user;
    }

    public function hasThreadFollowed()
    {
        return Follow::getFollowedThreadByUserId($this->id);
    }

    public function updateAccount()
    {
        if(!$this->validate()) {
            throw new ValidationException;
        }

        $db = DB::conn();
        $params = array(
            'fname' => $this->fname,
            'lname' => $this->lname,
            'username' => $this->new_username,
            'email' => $this->new_email,
        );
        $where = array(
            'id' => $this->id
        );
        try {
            $db->update(self::TABLE_NAME, $params, $where);    
        } catch (PDOException $e) {

        }
        
    }

    public function updateProfile()
    {
        if(!$this->validate()) {
            throw new ValidationException;
        }

        $db = DB::conn();
        $params = array(
            'company' => $this->company,
            'division' => $this->division,
            'specialization' => $this->specialization
        );
        $where = array(
            'id' => $this->id
        );
        try {
            $db->update(self::TABLE_NAME, $params, $where);    
        } catch (PDOException $e) {

        }

    }

    public function updatePassword()
    {
        if(!$this->validate()) {
            throw new ValidationException;
        }

        $password = hash_password($this->password);

        $db = DB::conn();

        $params = array(
            'password' => $password['hash'],
            'salt' => $password['salt'],
        );

        $where = array(
            'id' => $this->id
        );

        try {
            $db->update(self::TABLE_NAME, $params, $where);    
        } catch (PDOException $e) {

        }
    }

    public static function getUsernameEmailById($user_id)
    {
        $db = DB::conn();
        return $db->row("SELECT username, email FROM user WHERE id = ?", array($user_id));
    }

    public static function getFollowedThreadsById(&$thread_ids, &$threads_followed)
    {
        foreach($thread_ids as $thread) {
            $threads_followed[] = Thread::getById($thread['thread_id']);
        }
    }

}