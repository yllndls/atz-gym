<?php
    session_start();

    // - call controller files
    include_once '../src/ProductController.php';
    include_once '../src/UserController.php';
    include_once '../src/MembershipController.php';
    include_once '../src/TransactionController.php';

    // - init controllers
    $productCntrl = new ProductController();
    $userCntrl = new UserController();
    $membershipCntrl = new MembershipController();
    $transactionCntrl = new TransactionController();

    // - validate auth
	if (!isset($_SESSION['user_type']) && $_SESSION['user_type'] !== USER_TYPE_MEMBER) {
		header('location:index.php');
	}

    // - results validation messages
    $sess_result_flg = false;
    $sess_header = '';
    $sess_mssg = '';
    $sess_mssg_type = '';
    if (isset($_SESSION['result']) && isset($_SESSION['timestamp'])) {
        $current_time = time();
        $session_time = $_SESSION['timestamp'];
        $timeout = 3;

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

    // - URL segmentation
	$requestUri = $_SERVER['REQUEST_URI'];
	$requestPath = strtok($requestUri, '?');
	$urlSegment = explode('/', trim($requestPath, '/'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" type="image/png" sizes="16x16" href="">
    <title>Admin ~ ATZ Fitness Gym</title>

    <link href="../public/assets/css/admin/bootstrap.min.css" rel="stylesheet">
    <link href="../public/assets/css/admin/steps.css" rel="stylesheet">
    <link href="../public/assets/css/admin/sweetalert.css" rel="stylesheet" type="text/css">
    <link href="../public/assets/css/admin/style.css" rel="stylesheet">
	<link href="../public/assets/css/admin/blue.css" rel="stylesheet">
    <link href="../public/assets/css/admin/dropify.min.css" rel="stylesheet">
    <link href="../public/assets/css/front/sweetalert2.min.css" rel="stylesheet"  type="text/css">

    <!-- angular libraries-->
	<script src="../src/angular/js/angular.min.js"></script>
	<script src="../src/angular/js/angular-ui-router.min.js"></script>

	<!-- angular app * controller -->
	<script src="../src/angular/app.js"></script>
	<script src="../src/angular/services.js"></script>
	<script src="../src/angular/constant.js"></script>
	<script src="../src/angular/controller/GymTransactionController.js"></script>
    <script src="../src/angular/controller/GymOrderController.js"></script>

    <!-- cron -->
	<script src="../src/angular/controller/CronController.js"></script>
</head>
<body class="fix-header card-no-border" ng-app="GymFitness">
    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="navbar-brand" href="dashboard.php">
						<b class="text-white font-weight-bold">ATZ</b> Fitness Gym
					</a>
                </div>

                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <li class="nav-item m-l-10"> 
							<a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect" href="javascript:void(0)"><i class="mdi mdi-backburger"></i></a>
						</li>
                    </ul>

                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<img src="../public/assets/image/profile/<?= $_SESSION['profile_img']; ?>" alt="user" class="profile-pic" />
							</a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="../public/assets/image/profile/<?= $_SESSION['profile_img']; ?>" alt="user"></div>
                                            <div class="u-text">
                                                <h4><?= ucfirst($_SESSION['fname'])?></h4>
                                                <p class="text-muted"><?= $_SESSION['email']; ?></p>
											</div>
                                        </div>
                                    </li>
                                    <li><a href="../src/providers/Logout.php"><i class="mdi mdi-power"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="left-sidebar">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li>
                            <a class="waves-effect" href="dashboard.php" aria-expanded="false">
                                <i class="mdi mdi-gauge"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-small-cap">MANAGEMENT</li>
                        <li>
                            <a class="waves-effect" href="subscription.php" aria-expanded="false">
                                <i class="mdi mdi-hexagon-multiple"></i>
                                <span class="hide-menu">Subscriptions</span>
                            </a>
                        </li>
                        <li class="<?= in_array($urlSegment[2], ['users.php','membership.php', 'membership-plan.php']) ? 'active':'';?>">
                            <a class="has-arrow waves-effect" href="#">
                                <i class="mdi mdi-account-multiple-outline"></i>
                                <span class="hide-menu">Users</span>
                            </a>
                            <ul class="collapse">
                                <li><a href="users.php">User List</a></li>
                                <li><a href="membership.php">Membership List</a></li>
                            </ul>
                        </li>
                        <li class="<?= in_array($urlSegment[2], ['product.php','product-category.php', 'product-form.php']) ? 'active':'';?>">
                            <a class="has-arrow waves-effect" href="#" aria-expanded="false">
                                <i class="mdi mdi-tag-multiple"></i>
                                <span class="hide-menu">Shop</span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="product.php">Product List</a></li>
                                <li><a href="product-category.php">Product Category</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="waves-effect" href="orders.php" aria-expanded="false">
                                <i class="mdi mdi-shopping"></i>
                                <span class="hide-menu">Orders</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect" href="transactions.php" aria-expanded="false">
                                <i class="mdi mdi-trending-up"></i>
                                <span class="hide-menu">Transactions</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>