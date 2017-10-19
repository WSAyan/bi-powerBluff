<?php
/**
 * Created by PhpStorm.
 * User: wahid.sadique
 * Date: 10/19/2017
 * Time: 3:54 PM
 */

class Redirect
{
    public static function loadPage($url)
    {
        ob_start();
        header('Location: '.$url);
        ob_end_flush();
        die();
    }
}
