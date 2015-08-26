<?php

function encode_quotes($string)
{
    if (!isset($string)) return;
    echo htmlspecialchars($string, ENT_QUOTES);
}

function readable_text($no_br_string)
{
    $no_br_string = htmlspecialchars($no_br_string, ENT_QUOTES);
    $no_br_string = nl2br($no_br_string);
    return $no_br_string;
}

function redirect($url)
{
    header("Location: " . url($url));
}

function redirect_to_login()
{
    if(!isset($_SESSION['username'])) {
        redirect('user/login');
    }
}