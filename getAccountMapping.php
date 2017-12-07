<?php
/**
 * Created by PhpStorm.
 * User: wahid.sadique
 * Date: 12/7/2017
 * Time: 12:30 PM
 */
require_once 'model/Crud.php';
require_once 'utils/Redirect.php';

if (isset($_GET['clientId']) && isset($_GET['reportId'])) {
    $db = new Crud();
    $clientId = $_GET['clientId'];
    $reportId = $_GET['reportId'];
    $captions = $db->getLeafCaptionList($clientId, $reportId);
    if ($captions != null) {
        $captionList = array();
        $i = 0;
        while ($row = $captions->fetch_assoc()) {
            $captionList[$i] = $row;
            $i++;
        }
        echo json_encode($captionList);
    } else {
        Redirect::loadPage("login.php");
        exit();
    }
} else {
    Redirect::loadPage("login.php");
    exit();
}