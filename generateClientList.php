<?php
/**
 * Created by PhpStorm.
 * User: wahid.sadique
 * Date: 10/31/2017
 * Time: 12:34 PM
 */

require_once 'model/Crud.php';
require_once 'utils/Redirect.php';

if (isset($_GET['deptId'])) {
    $db = new Crud();
    $deptId = $_GET['deptId'];
    $clients = $db->getAllClients($deptId);
    if ($clients != null) {
        $clientList = array();
        $i = 0;
        while ($row = $clients->fetch_assoc()) {
            $clientList[$i] = $row;
            $i++;
        }
        echo json_encode($clientList);
    } else {
        Redirect::loadPage("login.php");
        exit();
    }
} else {
    Redirect::loadPage("login.php");
    exit();
}