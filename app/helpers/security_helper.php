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
    $user_id = get_authenticated_user_id($_SESSION['userid']);
    
    switch ($request) {
        case 'thread':
            $thread_author_id = Thread::getAuthorById($request_id);
            if($user_id !== $thread_author_id) {
                redirect('notfound/pagenotfound');
            }
            break;
        case 'comment':
            $comment_author_id = Comment::getAuthorById($request_id);
            if($user_id !== $comment_author_id) {
                redirect('notfound/pagenotfound');
            }
            break;
        default:
            redirect('notfound/pagenotfound');
            break;
    }
}

function get_authenticated_user_id($user_id)
{
    try {
        return User::getAuthenticatedId($user_id);
    } catch (RecordNotFoundException $e) {
        redirect('notfound/pagenotfound');
    }
}
