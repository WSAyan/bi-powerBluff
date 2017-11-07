<?php
/**
 * Created by PhpStorm.
 * User: wahid.sadique
 * Date: 10/23/2017
 * Time: 6:15 PM
 */
require_once 'utils/Redirect.php';
if (isset($_POST['user'])) {
    if ($_POST['user'] == 'admin') {
        openExcel();
    }
} else {
    Redirect::loadPage("login.php");
    exit();
}

function openExcel()
{
    $cmd = "C:/Program Files (x86)/Microsoft Office/Office15/EXCEL.EXE";
    exec($cmd);
}