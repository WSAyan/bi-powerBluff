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
if (isset($_SESSION['sid'])) {
    if ($_SESSION["sid"] == "1") {
        $db = new Crud();
        $departments = $db->getAllDepartments();
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
    <link rel="stylesheet" href="view/dist/css/jquery.nestable.css">
    <link rel="stylesheet" href="view/dist/css/style.css">

    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">

        <!-- Logo -->
        <a href="admin.php" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>BI</b>P</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>BI</b>Portal</span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
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
                                <!-- inner menu: contains the actual data -->
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
                    <!-- Tasks: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="view/dist/img/avatar04.png" class="user-image" alt="User Image">
                            <span class="hidden-xs">Administrator</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="view/dist/img/avatar04.png" class="img-circle" alt="User Image">

                                <p>
                                    Administrator
                                    <small>Southtech Limited</small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="row">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </div>
                                <!-- /.row -->
                            </li>
                            <!-- Menu Footer-->
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
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="index.php"><i class="fa fa-power-off"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- search form -->
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
                </div>
            </form>
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
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
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Design Report</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Reports</label>
                        <select id="reportsList" class="form-control select2" style="width: 100%;">
                            <option value="0" selected="selected">Select Report</option>

                        </select>
                    </div>
                </div>
            </div>

            <!--<div class="row">
                <div id="addedElements">
                    <input class="level_1" type="button" value="Add Navigation"/>
                </div>
            </div>-->
            <div class="row">
                <textarea id="nestable-output"></textarea>
            </div>
            <div class="row">
                <!--<div class="dd" id="nestable">
                    <ol class="dd-list">
                        <li class="dd-item" data-id="1">
                            <div class="dd-handle">Item 1</div>
                        </li>
                        <li class="dd-item" data-id="2">
                            <div class="dd-handle">Item 2</div>
                            <ol class="dd-list">
                                <li class="dd-item" data-id="3">
                                    <div class="dd-handle">Item 3</div>
                                </li>
                                <li class="dd-item" data-id="4">
                                    <div class="dd-handle">Item 4</div>
                                </li>
                                <li class="dd-item" data-id="5">
                                    <div class="dd-handle">Item 5</div>
                                    <ol class="dd-list">
                                        <li class="dd-item" data-id="6">
                                            <div class="dd-handle">Item 6</div>
                                        </li>
                                        <li class="dd-item" data-id="7">
                                            <div class="dd-handle">Item 7</div>
                                        </li>
                                        <li class="dd-item" data-id="8">
                                            <div class="dd-handle">Item 8</div>
                                        </li>
                                    </ol>
                                </li>
                                <li class="dd-item" data-id="9">
                                    <div class="dd-handle">Item 9</div>
                                </li>
                                <li class="dd-item" data-id="10">
                                    <div class="dd-handle">Item 10</div>
                                </li>
                            </ol>
                        </li>
                        <li class="dd-item" data-id="11">
                            <div class="dd-handle">Item 11</div>
                        </li>
                        <li class="dd-item" data-id="12">
                            <div class="dd-handle">Item 12</div>
                        </li>
                    </ol>
                </div>-->
                <div class="col-md-6">
                    <h3>Menu</h3>
                    <div class="dd nestable" id="nestable">
                        <ol class="dd-list">
                            <li class="dd-item" data-id="1" data-name="Item 1" data-slug="item-slug-1" data-new="0"
                                data-deleted="0">
                                <div class="dd-handle">Item 1</div>
                                <span class="button-delete btn btn-default btn-xs pull-right"
                                      data-owner-id="1">
                  <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                </span>
                                <span class="button-edit btn btn-default btn-xs pull-right"
                                      data-owner-id="1">
                  <i class="fa fa-pencil" aria-hidden="true"></i>
                </span>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="col-md-6">
                    <form class="form-inline" id="menu-add">
                        <h3>Add new menu item</h3>
                        <div class="form-group">
                            <label for="addInputName">Name</label>
                            <input type="text" class="form-control" id="addInputName" placeholder="Item name" required>
                        </div>
                        <div class="form-group">
                            <label for="addInputSlug">Slug</label>
                            <input type="text" class="form-control" id="addInputSlug" placeholder="item-slug" required>
                        </div>
                        <button class="btn btn-info" id="addButton">Add</button>
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
            </div>
        </section>

    </div>
    <!-- /.content-wrapper -->

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
<script src="view/plugins/chartjs/Chart.min.js"></script>
<script src="view/dist/js/pages/dashboard2.js"></script>
<script src="view/dist/js/demo.js"></script>
<script src="view/plugins/jquery.nestable.js"></script>
<script src="view/plugins/jquery.nestable++.js"></script>
<script src="view/dist/js/pages/designReport.js"></script>
<script>
    designReport.initialize();
</script>
</body>
</html>
