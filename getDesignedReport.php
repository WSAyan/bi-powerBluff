<?php
/**
 * Created by PhpStorm.
 * User: wahid.sadique
 * Date: 11/27/2017
 * Time: 11:15 AM
 */
require_once 'model/Crud.php';
require_once 'utils/Redirect.php';

if (isset($_GET['deptId']) && isset($_GET['clientId']) && isset($_GET['branchId']) && isset($_GET['reportId'])) {
    $db = new Crud();
    $deptId = $_GET['deptId'];
    $clientId = $_GET['clientId'];
    $branchId = $_GET['branchId'];
    $reportId = $_GET['reportId'];

    $report = $db->getDesignedReport($deptId, $clientId, $branchId, $reportId);
    if ($report != null) {
        echo $report;
    } else {
        Redirect::loadPage("login.php");
    }
} else {
    Redirect::loadPage("login.php");
}
