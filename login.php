<?php
/**
 * Created by PhpStorm.
 * User: wahid.sadique
 * Date: 10/19/2017
 * Time: 12:03 PM
 */
require_once 'model/Crud.php';
require_once 'utils/Redirect.php';
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BIPortal | Log in</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="view/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="view/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="view/plugins/iCheck/square/blue.css">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="login.php"><b>BI</b>Portal</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign In or Register</p>

        <form action="logInAuthenticator.php" method="post">
            <div class="form-group has-feedback">
                <input required type="text" name="username" class="form-control" placeholder="Username">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input required type="password" name="password" class="form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox"> Remember Me
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" id="signIn" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
                <!-- /.col -->
                <!--onclick="window.location.href='admin.php'"-->
            </div>
        </form>

        <a href="#">I forgot my password</a><br>
        <a href="registration.php" class="text-center">Register a new membership</a>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

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
<script src="view/plugins/jQueryValidation/jquery.validate.min.js"></script>
<script src="view/dist/js/pages/login.js"></script>
<script>
    logIn.initialize();
</script>
</body>
</html>


