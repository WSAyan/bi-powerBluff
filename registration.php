<?php
/**
 * Created by PhpStorm.
 * User: wahid.sadique
 * Date: 10/19/2017
 * Time: 12:03 PM
 */
require_once 'model/Crud.php';
require_once 'utils/Redirect.php';
$db = new Crud();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BIPortal | Registration Page</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="view/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="view/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="view/plugins/iCheck/square/blue.css">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        <a href="index.php"><b>ASCEND</b>BI</a>
    </div>

    <div class="register-box-body">
        <p class="login-box-msg">Register a new membership</p>

        <form action="register.php" method="post">
            <div class="form-group has-feedback">
                <label>User type</label>
                <input type="radio" name="user_type" value="admin"> Admin
                <input type="radio" name="user_type" value="user"> User
            </div>
            <div class="form-group has-feedback">
                <input type="text" name="username" class="form-control" placeholder="User name">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="email" name="email" class="form-control" placeholder="Email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="re_password" class="form-control" placeholder="Retype password">
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>
            <div class="row">
                <!-- /.col -->
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                </div>
                <!-- /.col -->
            </div>
        </form>


        <a href="login.php" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 2.2.3 -->
<script src="view/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="view/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="view/plugins/iCheck/icheck.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
<script>
    registration.initialize();
</script>
</body>
</html>

