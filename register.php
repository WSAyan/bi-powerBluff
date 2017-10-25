<?php
/**
 * Created by PhpStorm.
 * User: wahid.sadique
 * Date: 10/25/2017
 * Time: 1:01 PM
 */
require_once 'model/Crud.php';
require_once 'utils/Redirect.php';
$db = new Crud();
if (isset($_POST['user_type']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['re_password'])) {
    $userType = $_POST['user_type'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rePassword = $_POST['re_password'];
    $userTypeCode = 0;
    switch ($userType) {
        case "admin":
            $userTypeCode = 201;
            break;
        case "user":
            $userTypeCode = 301;
            break;
    }

    if ($password == $rePassword) {
        $isExists = $db->isUserExisted($email);
        if(!$isExists){
            $user = $db->storeUser($userTypeCode, $username, $email, $password);
            if ($user != null) {
                Redirect::loadPage("admin.php");
            } else {
                echo 'Something went wrong!';
            }
        }
    }
}else{
    echo "Registration fails!";
}