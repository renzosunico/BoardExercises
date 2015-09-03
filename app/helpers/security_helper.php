<?php

function hash_password($password)
{
    $salt = bin2hex(openssl_random_pseudo_bytes(255));
    $hash = crypt($password, '$2a$11$' . $salt);

    $result['salt'] = $salt;
    $result['hash'] = $hash;

    return $result;
}