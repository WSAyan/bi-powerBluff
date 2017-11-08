<?php
/**
 * Created by PhpStorm.
 * User: wahid.sadique
 * Date: 10/23/2017
 * Time: 2:14 PM
 */
require_once 'utils/OpenDirectory.php';
require_once 'model/Crud.php';
require_once 'utils/Redirect.php';
session_start();
$username = null;
if (isset($_SESSION['sid']) && isset($_SESSION['user'])) {
    if ($_SESSION["sid"] == "admin") {
        $db = new Crud();
        $filesList = OpenDirectory::getFileList("reports");
        $departments = $db->getAllDepartments();
        $savedReports = $db->getSavedReports();
        $username = $_SESSION["user"];
    } else {
        Redirect::loadPage("login.php");
    }
} else {
    Redirect::loadPage("login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BIPortal</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="view/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="view/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" href="view/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="view/dist/css/skins/_all-skins.min.css">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <a href="admin.php" class="logo">
            <span class="logo-mini"><b>BI</b>P</span>
            <span class="logo-lg"><b>BI</b>Portal</span>
        </a>

        <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">10</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 10 notifications</li>
                            <li>
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-warning text-yellow"></i> Very long description here that
                                            may not fit into the
                                            page and may cause design problems
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-users text-red"></i> 5 new members joined
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-user text-red"></i> You changed your username
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="#">View all</a></li>
                        </ul>
                    </li>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="view/dist/img/avatar04.png" class="user-image" alt="User Image">
                            <span class="hidden-xs"><?PHP
                                echo "{$username}"
                                ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="view/dist/img/avatar04.png" class="img-circle" alt="User Image">

                                <p>
                                    <?PHP
                                    echo "{$username}";
                                    ?>
                                    <small>Southtech Limited</small>
                                </p>
                            </li>


                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="#" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="index.php"><i class="fa fa-power-off"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <aside class="main-sidebar">
        <section class="sidebar">
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
                </div>
            </form>
            <ul class="sidebar-menu">
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dashboard"></i> <span>Dashboards</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <?PHP
                        $i = 0;
                        foreach ($departments as $dept) {
                            if ($i == 0) {
                                echo "<li class='active'><a href=\"admin.php\"><i class=\"fa fa-circle-o\"></i>{$dept['deptName']}</a></li>";
                            } /*else {
                                echo "<li><a href=\"admin.php\"><i class=\"fa fa-circle-o\"></i>{$dept['deptName']}</a></li>";
                            }*/
                            $i++;
                        }
                        ?>
                    </ul>
                </li>

                <li><a href="#"><i class="fa fa-book"></i> <span>Create Report</span></a></li>
                <li><a href="designReport.php"><i class="fa fa-pencil"></i> <span>Design Report</span></a></li>
            </ul>
        </section>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <button type="button" id="createReport" class="btn btn-block btn-info" style="width: 150px">
                Create Report
            </button>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Create Report</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Reports List</h3>

                            <div class="box-tools">
                                <ul class="pagination pagination-sm no-margin pull-right">
                                    <li><a href="#">&laquo;</a></li>
                                    <li><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">&raquo;</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                            <table id="reportTable" class="table">
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Size</th>
                                    <th style="width: 40px">Status</th>
                                </tr>

                                <?PHP
                                $i = 0;
                                foreach ($filesList as $file) {
                                    $i++;
                                    echo "<tr id=\"{$file['name']}\" data-toggle=\"modal\" data-target=\"#reportSaveModal\">\n";
                                    echo "<td>$i</td>\n";
                                    echo "<td id=\"reportRowName\">{$file['name']}</td>\n";
                                    echo "<td>", date('Y-m-d H:i:s', $file['lastmod']), "</td>\n";
                                    echo "<td>{$file['size']}</td>\n";
                                    if (in_array($file['name'], $savedReports)) {
                                        echo "<td><span id=\"statusSpan\" class=\"label label-success\" >Saved</span></td>";
                                    } else {
                                        echo "<td><span id=\"statusSpan\" class=\"label label-warning\" >Pending</span></td>";
                                    }
                                    echo "</tr>\n";
                                }
                                echo "</tbody>\n";
                                echo "</table>\n\n";
                                ?>
                                <div class="example-modal">
                                    <div class="modal fade" id="reportSaveModal" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="reportModalHeader">Save Report</h4>
                                                </div>
                                                <div class="modal-body form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Departments</label>
                                                                <select id="departmentsList"
                                                                        class="form-control select2"
                                                                        style="width: 100%;">
                                                                    <option value="0" selected="selected">Select
                                                                        Department
                                                                    </option>
                                                                    <?PHP
                                                                    $i = 0;
                                                                    foreach ($departments as $dept) {
                                                                        if ($i == 0) {
                                                                            echo "<option value='{$dept['id']}'>{$dept['deptName']}</option>";
                                                                        }
                                                                        $i++;
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Clients</label>
                                                                <select id="clientList" class="form-control select2"
                                                                        style="width: 100%;">
                                                                    <option value="0" selected="selected">All Clients
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Branches</label>
                                                                <select id="branchesList" class="form-control select2"
                                                                        style="width: 100%;">
                                                                    <option value="0" selected="selected">All Branches
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Reports</label>
                                                                <select id="reportsList" class="form-control select2"
                                                                        style="width: 100%;">
                                                                    <option value="0" selected="selected">Select
                                                                        Report
                                                                    </option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <label>PowerBI URL</label>
                                                                <input id="urlInput" class="form-control"
                                                                       placeholder="URL"
                                                                       type="url">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default pull-left"
                                                            data-dismiss="modal">Close
                                                    </button>
                                                    <button id="saveReport" type="button" class="btn btn-primary"
                                                            data-dismiss="modal">Save
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--<tr>
                                    <td>1.</td>
                                    <td>Update software</td>
                                    <td>11-7-2014</td>
                                    <td><span class="badge bg-red">55%</span></td>
                                    <td><span class="label label-success">Approved</span></td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td>Clean database</td>
                                    <td>11-7-2014</td>
                                    <td><span class="badge bg-yellow">70%</span></td>
                                    <td><span class="label label-danger">Denied</span></td>
                                </tr>
                                <tr>
                                    <td>3.</td>
                                    <td>Cron job running</td>
                                    <td>11-7-2014</td>
                                    <td><span class="badge bg-light-blue">30%</span></td>
                                    <td><span class="label label-success">Approved</span></td>
                                </tr>
                                <tr>
                                    <td>4.</td>
                                    <td>Fix and squish bugs</td>
                                    <td>11-7-2014</td>
                                    <td><span class="badge bg-green">90%</span></td>
                                    <td><span class="label label-warning">Pending</span></td>
                                </tr>-->
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

            </div>
        </section>
    </div>

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2016 <a href="www.southtechgroup.com/">Southtech Limited</a>.</strong> All rights
        reserved.
    </footer>


</div>
<script src="view/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="view/bootstrap/js/bootstrap.min.js"></script>
<script src="view/plugins/fastclick/fastclick.js"></script>
<script src="view/dist/js/app.min.js"></script>
<script src="view/plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="view/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="view/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="view/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="view/dist/js/pages/reports.js"></script>
<script>
    reports.initialize();
</script>
</body>
</html>

