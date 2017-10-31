<?php
/**
 * Created by PhpStorm.
 * User: wahid.sadique
 * Date: 10/31/2017
 * Time: 3:03 PM
 */

require_once 'model/Crud.php';
require_once 'utils/Redirect.php';

if (isset($_POST['deptId']) && isset($_POST['clientId']) && isset($_POST['branchId']) && isset($_POST['reportId']) && isset($_POST['reportURL']) && isset($_POST['reportName'])) {
    $db = new Crud();
    $deptId = $_POST['deptId'];
    $clientId = $_POST['clientId'];
    $branchId = $_POST['branchId'];
    $reportId = $_POST['reportId'];
    $reportURL = $_POST['reportURL'];
    $reportName = $_POST['reportName'];

    $reports = $db->saveReport($reportId, $clientId, $deptId, $branchId, $reportURL, $reportName);
    if ($reports != null) {
        echo json_encode($reports);
    } else {
        Redirect::loadPage("login.php");
        //echo json_encode($reports);
    }
} else {
    Redirect::loadPage("login.php");
    //echo "post error";
}