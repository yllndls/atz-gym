<?php
    include_once '../src/config/helpers.php';

    session_start();

    // - already authenticated
    if (isset($_SESSION['user_type']) && $_SESSION['user_type'] !== USER_TYPE_MEMBER) {
		header('location:dashboard.php');
	}

    // - results validation messages
    $sess_result_flg = false;
    $sess_header = '';
    $sess_mssg = '';
    $sess_mssg_type = '';
    if (isset($_SESSION['result']) && isset($_SESSION['timestamp'])) {
        $current_time = time();
        $session_time = $_SESSION['timestamp'];
        $timeout = 10;

        $sess_result_flg = true;
        $sess_header = $_SESSION['title'];
        $sess_mssg = $_SESSION['message'];
        $sess_mssg_type = $_SESSION['message_type'];

        if (($current_time - $session_time) > $timeout) {
            unset($_SESSION['result']);
            unset($_SESSION['params']);
            unset($_SESSION['timestamp']);
            unset($_SESSION['title']);
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
            $sess_result_flg = false;
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>Gym Management</title>

    <link href="../public/assets/css/admin/bootstrap.min.css" rel="stylesheet">
    <link href="../public/assets/css/admin/steps.css" rel="stylesheet">
    <link href="../public/assets/css/admin/sweetalert.css" rel="stylesheet" type="text/css">
    <link href="../public/assets/css/admin/style.css" rel="stylesheet">
	<link href="../public/assets/css/admin/blue.css" rel="stylesheet">
</head>
<body class="fix-header card-no-border">
    <section id="wrapper">
        <div class="login-register" style="background-image:url(../public/assets/image/system/admin_login_bg.jpg);">
            <div class="login-box card">
                <div class="card-body">
                    <div class="col-md-12 text-center mb-3">
                        <img src="../public/assets/image/system/logo_v2.png" width="200" alt=""/>
                    </div>
                    <div class="alert alert-<?= $sess_mssg_type; ?> <?= !!$sess_result_flg ? 'd-block':'d-none'?>" role="alert">
                        <p class="alert-heading m-0"><b><?= $sess_header; ?></b></p>
                        <small><?= $sess_mssg; ?></small>
                    </div>
                    <form action="../src/providers/Login.php" method="POST" class="form-horizontal form-material">
                        <input type="hidden" name="type_id" value="1">
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="email" placeholder="Email" name="email" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" placeholder="Password" name="password" required/>
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <div class="col-xs-12">
                                <select class="form-control" name="">
                                    <option selected>Login Type</option>
                                    <option value="1">Administrator</option>
                                    <option value="2">Trainer</option>
                                </select>
                            </div>
                        </div> -->
                        <div class="form-group row">
                            <div class="col-md-12 font-14">
                                <div class="checkbox checkbox-primary pull-left p-t-0">
                                    <input id="checkbox-signup" type="checkbox">
                                    <label for="checkbox-signup"> Remember me </label>
                                </div> 
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-danger btn-lg btn-block text-uppercase waves-effect waves-light" type="submit" name="login">Log In</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="../public/assets/js/admin/plugins/jquery.min.js"></script>

    <!-- Bootstrap tether Core JavaScript -->
    <script src="../public/assets/js/admin/plugins/popper.min.js"></script>
    <script src="../public/assets/js/admin/plugins/bootstrap.min.js"></script>

    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../public/assets/js/admin/plugins/jquery.slimscroll.js"></script>

    <!--Wave Effects -->
    <script src="../public/assets/js/admin/plugins/waves.js"></script>

    <!--Menu sidebar -->
    <script src="../public/assets/js/admin/plugins/sidebarmenu.js"></script>

    <!--stickey kit -->
    <script src="../public/assets/js/admin/plugins/sticky-kit.min.js"></script>
    <script src="../public/assets/js/admin/plugins/jquery.sparkline.min.js"></script>

    <!--Custom JavaScript -->
    <script src="../public/assets/js/admin/plugins/custom.min.js"></script>

    <!-- <script src="../assets/plugins/moment/min/moment.min.js"></script> -->
    <script src="../public/assets/js/admin/plugins/jquery.steps.min.js"></script>
    <script src="../public/assets/js/admin/plugins/jquery.validate.min.js"></script>

    <!-- Sweet-Alert  -->
    <script src="../public/assets/js/admin/plugins/sweetalert.min.js"></script>
    <script src="../public/assets/js/admin/plugins/steps.js"></script>
</body>
</html>