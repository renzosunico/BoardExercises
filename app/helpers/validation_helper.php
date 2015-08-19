<?php

function validate_between($check, $min, $max)
{
	$n = mb_strlen($check);

	return $min <= $n && $n <= $max;
}

function validate_chars($check)
{
	return preg_match('/^[[:alnum:]]*$/', $check);
}

function validate_alpha($check)
{
	return preg_match('/^[[:alpha:] -.]*$/', $check);
}

function validate_email($check)
{
	return preg_match('/^\w+([-+.\']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/', $check);
}

function validate_existence($check, $type)
{
	return User::isValidUsernameEmail($check, $type);
}