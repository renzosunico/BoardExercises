<?php
function error_handler($error, $errorString)
{
    if(strpos($errorString, 'No such file or directory') >= 0) {
        redirect('notfound/pagenotfound');
    }
}
set_error_handler('error_handler');

function exception_handler($exception)
{
    if(strpos($exception, 'RecordNotFoundException')) {
        redirect('notfound/pagenotfound');
    }
}
set_exception_handler('exception_handler');
