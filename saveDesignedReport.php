<?php
/**
 * Created by PhpStorm.
 * User: wahid.sadique
 * Date: 11/13/2017
 * Time: 3:03 PM
 */
require_once 'model/Crud.php';
require_once 'utils/Redirect.php';

if (isset($_POST['deptId']) && isset($_POST['clientId']) && isset($_POST['branchId']) && isset($_POST['reportId']) && isset($_POST['captionList'])) {
    $db = new Crud();
    $deptId = $_POST['deptId'];
    $clientId = $_POST['clientId'];
    $branchId = $_POST['branchId'];
    $reportId = $_POST['reportId'];
    $captionList = $_POST['captionList'];

    $reports;
    if ($reports != null) {
        echo json_encode($reports);
    } else {
        Redirect::loadPage("login.php");
    }
} else {
    Redirect::loadPage("login.php");
}
