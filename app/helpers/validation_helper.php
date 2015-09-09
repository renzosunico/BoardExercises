<?php

function validate_between($check, $min, $max)
{
    $length = mb_strlen($check);
    return $min <= $length && $length <= $max;
}

function validate_chars($check)
{
    $evaluation = ctype_alnum($check);
    return empty($check) ? true : $evaluation;
}

function validate_alpha($check)
{
    return empty($check) ? true : preg_match('/^[[:alpha:] \-()]*$/', $check);
}

function validate_email($check)
{
    return empty($check) ? false : filter_var($check, FILTER_VALIDATE_EMAIL);
}

function validate_existence($check, $type)
{
    return empty($check) ? true : User::isValidUsernameEmail($check, $type);
}

function validate_content($check)
{
    return empty($check) ? false : true;
}

function confirm_password($check)
{
    $password = Param::get('password');
    return $check === $password;
}

function validate_changes($check, $column)
{
    $original_value = User::getUsernameEmailById($_SESSION['userid']);

    switch($column) {
        case 'username':
            if($check !== $original_value['username']) {
                if(!User::isValidUsernameEmail($check, $column)) {
                    return false;
                }
            }
            break;
        case 'email':
            if($check !== $original_value['email']) {
                if(!User::isValidUsernameEmail($check, $column)) {
                    return false;
                }
            }
            break;
    }
    return true;
}