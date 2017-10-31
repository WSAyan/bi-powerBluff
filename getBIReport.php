<?php
/**
 * Created by PhpStorm.
 * User: wahid.sadique
 * Date: 10/31/2017
 * Time: 6:42 PM
 */

require_once 'model/Crud.php';
require_once 'utils/Redirect.php';

if (isset($_POST['deptId']) && isset($_POST['clientId']) && isset($_POST['branchId']) && isset($_POST['reportId'])) {
    $db = new Crud();
    $deptId = $_POST['deptId'];
    $clientId = $_POST['clientId'];
    $branchId = $_POST['branchId'];
    $reportId = $_POST['reportId'];

    $reportURL = $db->showReport($reportId, $clientId, $deptId, $branchId);
    if ($reportURL != null) {
        echo $reportURL;
    } else {
        Redirect::loadPage("login.php");
        //echo $reportURL;
    }
} else {
    Redirect::loadPage("login.php");
    //echo "post error";
}