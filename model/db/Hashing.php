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
        $salt = self::$algo .
            self::$cost .
            '$' . self::unique_salt();
        $encrypted = crypt($password, $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    public static function check_password($password, $salt, $hash)
    {
        $new_hash = crypt($password, $salt);
        return ($hash == $new_hash);
    }
}