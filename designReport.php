<?php
/**
 * Created by PhpStorm.
 * User: wahid.sadique
 * Date: 11/2/2017
 * Time: 12:40 PM
 */
require_once 'utils/OpenDirectory.php';
require_once 'model/Crud.php';
require_once 'utils/Redirect.php';
session_start();
$username = null;
if (isset($_SESSION['sid']) && isset($_SESSION['user'])) {
    if ($_SESSION["sid"] == "admin") {
        $db = new Crud();
        $departments = $db->getAllDepartments();
        $username = $_SESSION['user'];
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
    <link rel="stylesheet" href="view/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="view/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="view/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="view/dist/css/jquery.nestable.css">
    <link rel="stylesheet" href="view/dist/css/style.css">

    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <header class="main-header">
        <a href="admin.php" class="logo">
            <span class="logo-mini"><b>A</b>BI</span>
            <span class="logo-lg"><b>ASCEND</b>BI</span>
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
                            <li class="user-header">
                                <img src="view/dist/img/avatar04.png" class="img-circle" alt="User Image">

                                <p>
                                    <?PHP
                                    echo "{$username}"
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

                <li><a href="reports.php"><i class="fa fa-book"></i> <span>Create Report</span></a></li>
                <li><a href="#"><i class="fa fa-pencil"></i> <span>Design Report</span></a></li>
            </ul>
        </section>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Design Report</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Reports</label>
                        <select id="reportsList" class="form-control select2" style="width: 100%;">
                            <option value="0" selected="selected">Select Report</option>

                        </select>
                        <button id="saveDesign" class="btn btn-success">Save</button>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-4">
                    <h3>Report Template</h3>
                    <div class="dd" id="nestable-json"></div>
                </div>

                <div class="col-md-4">
                    <form class="form-inline" id="menu-add">
                        <h3>Add new caption</h3>
                        <div class="form-group">
                            <label for="addInputName">Name</label>
                            <input type="text" class="form-control" id="addInputName" placeholder="Item name" required>
                        </div>
                        <button type="button" class="btn btn-info" id="addButton">Add</button>
                    </form>

                    <form class="" id="menu-editor" style="display: none;">
                        <h3>Editing <span id="currentEditName"></span></h3>
                        <div class="form-group">
                            <label for="addInputName">Name</label>
                            <input type="text" class="form-control" id="editInputName" placeholder="Item name" required>
                        </div>
                        <div class="form-group">
                            <label for="addInputSlug">Slug</label>
                            <input type="text" class="form-control" id="editInputSlug" placeholder="item-slug">
                        </div>
                        <button class="btn btn-info" id="editButton">Edit</button>
                    </form>

                </div>
                <div class="col-md-4">
                    <h3>Map Accounts</h3>
                    <div id="mapperHolder">

                    </div>
                    <!--<form class="form-inline">
                        <button class="btn btn-default" id="captionId">levelId</button>
                        <select class="form-control select2" id="accountListId" multiple="multiple" data-placeholder="Select a State"
                                style="width: 100%;">
                            <option>Alabama</option>
                            <option>Alaska</option>
                            <option>California</option>
                            <option>Delaware</option>
                            <option>Tennessee</option>
                            <option>Texas</option>
                            <option>Washington</option>
                        </select>
                    </form>-->

                </div>

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
<script src="view/plugins/select2/select2.full.min.js"></script>
<script src="view/plugins/input-mask/jquery.inputmask.js"></script>
<script src="view/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="view/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script src="view/plugins/fastclick/fastclick.js"></script>
<script src="view/dist/js/app.min.js"></script>
<script src="view/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="view/dist/js/pages/designReport.js"></script>
<!--<script src="view/plugins/jQuery/jquery-1.11.3.min.js"></script>-->
<script src="view/plugins/jquery.nestable.min.js"></script>
<script>
    designReport.initialize();
</script>
</body>
</html>
