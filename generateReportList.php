<?php
/**
 * Created by PhpStorm.
 * User: wahid.sadique
 * Date: 10/30/2017
 * Time: 6:37 PM
 */

require_once 'model/Crud.php';
require_once 'utils/Redirect.php';

if (isset($_GET['report'])) {
    $db = new Crud();
    $reports = $db->getReports();
    if ($reports != null) {
        $reportsList = array();
        $j = 0;
        while ($row = $reports->fetch_assoc()) {
            $reportsList[$j] = $row;
            $j++;
        }
        echo json_encode($reportsList);
    } else {
        Redirect::loadPage("login.php");
    }
} else {
    Redirect::loadPage("login.php");
}