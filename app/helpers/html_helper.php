<?php

CONST START_RAND_NO = 0;
CONST END_RAND_NO = 7;

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

function redirect($url,$params = array())
{
    header("Location: " . url($url, $params));
}



function redirect_to_login()
{
    if(!isset($_SESSION['username'])) {
        redirect('user/login');
    }
}

function get_welcome_message()
{
   $welcome_messages = array(
                'Welcome ',
                'Good To See You ',
                'Good Day ',
                'Hi-ya ',
                'Nice To See You ',
                'Hey ',
                'Hey Good Looking ',
                'What\'s Up '
    );

   return $welcome_messages[rand(START_RAND_NO, END_RAND_NO)];
}