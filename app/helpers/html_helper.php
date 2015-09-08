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
    die();
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

function get_thread_comment($thread_id)
{
    $comment = Comment::getByThreadId($thread_id);
    echo $comment['body'];
}

function print_date($object)
{
    if($object instanceof Thread || $object instanceof Comment) {
        $date_string = "<p class=\"smallersize\">";
        //add date created
        $date_string .= " Created: " . date("l, F d, Y", strtotime($object->created));

        if($object->last_modified != "0000-00-00 00:00:00") {
            $date_string .= " Last Modified: " . date("l, F d, Y", strtotime($object->last_modified));
        }

        $date_string .= "</p>";

        echo $date_string;
    }
}