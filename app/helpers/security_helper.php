<?php

function hash_password($password)
{
    $salt = bin2hex(openssl_random_pseudo_bytes(255));
    $hash = crypt($password, '$2a$11$' . $salt);

    $result['salt'] = $salt;
    $result['hash'] = $hash;

    return $result;
}

function authorize_user_request($thread_id)
{
    $user_id = User::getIdByUsername($_SESSION['username']);
    $thread_author_id = Thread::getAuthorById($thread_id);
    if($user_id !== $thread_author_id) {
        redirect('notfound/pagenotfound');
    }
}