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
    return empty($check) ? true : filter_var($check, FILTER_VALIDATE_EMAIL);
}

function validate_existence($check, $type)
{
    return empty($check) ? true : User::isValidUsernameEmail($check, $type);
}

function confirm_password($check)
{
    $password = Param::get('password');
    return $check === $password;
}