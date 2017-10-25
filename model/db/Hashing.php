<?php
/**
 * Created by PhpStorm.
 * User: wahid.sadique
 * Date: 10/19/2017
 * Time: 12:01 PM
 */

class Hashing
{
    private static $algo = '$2a';
    private static $cost = '$10';

    public static function unique_salt()
    {
        return substr(sha1(mt_rand()), 0, 22);
    }

    public static function hash($password)
    {
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    public static function check_password($password, $salt, $hash)
    {
        $newHash = base64_encode(sha1($password . $salt, true) . $salt);
        return ($hash == $newHash);
    }
}