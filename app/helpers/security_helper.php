<?php

function hash_password($password)
{
    $salt = bin2hex(openssl_random_pseudo_bytes(255));
    $hash = crypt($password, '$2a$11$' . $salt);

    $result['salt'] = $salt;
    $result['hash'] = $hash;

    return $result;
}

function authorize_user_request($request_id, $request)
{
    switch ($request) {
        case 'thread':
            $thread_author_id = Thread::getAuthorById($request_id);
            if($_SESSION['userid'] !== $thread_author_id) {
                redirect('notfound/pagenotfound');
            }
            break;
        case 'comment':
            $comment_author_id = Comment::getAuthorById($request_id);
            if($_SESSION['userid'] !== $comment_author_id) {
                redirect('notfound/pagenotfound');
            }
            break;
        default:
            redirect('notfound/pagenotfound');
            break;
    }
}
