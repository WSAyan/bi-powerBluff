<?php
/**
 * Created by PhpStorm.
 * User: wahid.sadique
 * Date: 10/23/2017
 * Time: 6:15 PM
 */
if (isset($_POST['user'])) {
    if($_POST['user'] == 'admin'){
        openExcel();
    }
}

function openExcel()
{
    $cmd = "C:/Program Files (x86)/Microsoft Office/Office15/EXCEL.EXE";
    exec($cmd);
}