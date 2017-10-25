<?php
/**
 * Created by PhpStorm.
 * User: wahid.sadique
 * Date: 10/25/2017
 * Time: 3:45 PM
 */

require_once 'model/Crud.php';
require_once 'utils/Redirect.php';
$db = new Crud();
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = $db->logInAttempt($username, $password);
    if ($user != null) {
        Redirect::loadPage("admin.php");
    } else {
        echo 'Wrong username or password!';
    }
}