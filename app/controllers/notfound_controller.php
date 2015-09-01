<?php
class NotFoundController extends AppController
{
    public function pagenotfound()
    {
        header('HTTP/1.0 404 Not Found');
    }
}