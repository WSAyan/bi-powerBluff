<?php
/**
 * Created by PhpStorm.
 * User: wahid.sadique
 * Date: 11/7/2017
 * Time: 4:09 PM
 */
require_once 'model/Crud.php';
require_once 'utils/Redirect.php';
if (isset($_POST['username']) && isset($_POST['password'])) {
    $db = new Crud();
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = $db->logInAttempt($username, $password);
    if ($user != null) {
        session_start();
        $userType= $user['usertype'];
        $userName= $user['username'];
        $_SESSION["user"] = $userName;
        switch ($userType){
            case "201":
                $_SESSION["sid"] = "admin";
                Redirect::loadPage("admin.php");
                break;
            case "301":
                $_SESSION["sid"] = "user";
                Redirect::loadPage("user.php");
                break;
        }
    } else {
        Redirect::loadPage("login.php");
    }
} else {
    Redirect::loadPage("login.php");
}
