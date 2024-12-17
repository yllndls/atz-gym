<?php
    session_start();

    // - call controller
    include_once 'src/ProductController.php';
    include_once 'src/UserController.php';
	include_once 'src/MembershipController.php';

    // - init controllers
    $productCntrl = new ProductController();
    $userCntrl = new UserController();
	$membershipCntrl =  new MembershipController();

	// - URL segmentation
	$requestUri = $_SERVER['REQUEST_URI'];
	$requestPath = strtok($requestUri, '?');
	$urlSegment = explode('/', trim($requestPath, '/'));
	
	// - check authenticated user
	if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == USER_TYPE_MEMBER) {
		$not_authenticated_page = [
			'login.php',
			'register.php'
		];
		if (isset($urlSegment[1]) && in_array($urlSegment[1], $not_authenticated_page)) {
			header('location:index.php');
		}
	}

	// - need authenticaion to visit this page
	if (!isset($_SESSION['user_type'])) {
		$not_authenticated_page = [
			'settings.php',
			'my-plan.php',
			'cart.php'
		];
		if (isset($urlSegment[1]) && in_array($urlSegment[1], $not_authenticated_page)) {
			header('location:404.php');
		}
	}

	// - authenticated datas
	$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
	$fname = isset($_SESSION['fname']) ? $_SESSION['fname'] : '';
	$lname = isset($_SESSION['lname']) ? $_SESSION['lname'] : '';
	$profile = isset($_SESSION['profile_img']) ? $_SESSION['profile_img'] : '';

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

	// - data for user details
	$detail = array();
    $detail_result = $userCntrl->detail($user_id);
    if (!!$detail_result['success']) {
        $detail = $detail_result['data'];
    }

	// - current membership
	$curr_membership_data = array();
	$curr_membership = $membershipCntrl->user_latest_membership($user_id);
	if (!!$curr_membership['success']) {
        $curr_membership_data = $curr_membership['data'];
    }
    $membership_expired = isset($curr_membership_data['is_expired_flg']) ? $curr_membership_data['is_expired_flg'] : null;
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <title>ATZ Fitness Gym</title>

    <link rel="stylesheet" href="public/assets/css/front/style.css" type="text/css">
    <link rel="stylesheet" href="public/assets/css/front/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="public/assets/css/front/font-awesome.css" type="text/css">

    <link rel="stylesheet" href="public/assets/css/front/effect.css" type="text/css">
    <link rel="stylesheet" href="public/assets/css/front/animation.css" type="text/css">

    <link rel="stylesheet" href="public/assets/css/front/masterslider.css" type="text/css">
    <link rel="stylesheet" href="public/assets/css/front/ms-fullscreen.css" type="text/css">
    <link rel="stylesheet" href="public/assets/css/front/owl.carousel.css" type="text/css" media="all" >
    <link rel="stylesheet" href="public/assets/css/front/owl.transitions.css" type="text/css" media="all" >
    <link rel="stylesheet" href="public/assets/css/front/color.css" type="text/css">
	<link rel="stylesheet" href="public/assets/css/front/jquery.custombox.css" type="text/css">
	<link rel="stylesheet" href="public/assets/css/front/sweetalert2.min.css" type="text/css">

	<!-- angular libraries-->
	<script src="src/angular/js/angular.min.js"></script>
	<script src="src/angular/js/angular-ui-router.min.js"></script>

	<!-- angular app * controller -->
	<script src="src/angular/app.js"></script>
	<script src="src/angular/services.js"></script>
	<script src="src/angular/constant.js"></script>
	<script src="src/angular/controller/GymUserController.js"></script>
	<script src="src/angular/controller/GymTransactionController.js"></script>
	<script src="src/angular/controller/GymOrderController.js"></script>
</head> 
<body id="page-top" ng-app="GymFitness">
	<div class="wrapper hide-main-content"> 
		<section class="page">
			<!--Menu Desktop-->
			<div class="content-wrapper">
				<!--Header-->				
				<header id="header" class="header header-container alt reveal">
					<div class="container">
						<div class="row">
							<div class="col-md-2 col-sm-3 col-xs-3 logo">
								<a href="index.php"><img src="public/assets/image/system/logo_v1.png" height="80" alt=""/></a>
							</div>
							<div class="col-md-9 nav-container">
								<nav class="megamenu collapse navbar-collapse bs-navbar-collapse navbar-right mainnav col-md-10" role="navigation">
									<ul class="nav-menu">
										<li class="selected <?= in_array($urlSegment[1], ['index.php']) ? 'active':'';?>">
											<a href="index.php">HOME</a>
										</li>
										<li class="selected <?= in_array($urlSegment[1], ['about-us.php']) ? 'active':'';?>">
											<a href="#">ABOUT US</a>
											<ul class="child-nav">
												<li><a href="about-us.php#why-choose-us">Why Choose Us</a></li>
											</ul>
										</li>
										<li class="selected <?= in_array($urlSegment[1], ['membership.php']) ? 'active':'';?>">
											<a href="membership.php">MEMBERSHIP</a>
										</li>
										<li class="selected <?= in_array($urlSegment[1], ['products.php']) ? 'active':'';?>">
											<a href="products.php">SHOP</a>
										</li>
                                        <li class="selected <?= in_array($urlSegment[1], ['contact-us.php']) ? 'active':'';?>">
											<a href="contact-us.php">CONTACT US</a>
										</li>
										<?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == USER_TYPE_MEMBER) : ?>
											<li>
												<a href="#">
													<img src="public/assets/image/profile/<?= $profile; ?>" class="profile_rounded" width="30" height="30" alt="">
													<?= $fname .' '.$lname ?>
												</a>
												<ul class="child-nav">
													<li>
														<a href="settings.php">
															<i class="fa fa-gears"></i> 
															Account Settings
														</a>
													</li>
													<li>
														<a href="my-plan.php">
															<i class="fa fa-tags"></i> 
															My Plan
														</a>
													</li>
													<li  ng-controller="GymOrderController" ng-init="initCart(<?= $user_id; ?>)" ng-clock>
														<a href="cart.php">
															<i class="fa fa-shopping-cart"></i> 
															My cart <span class="badge badge_danger">{{ cart_count }}</span>
														</a>
													</li>
													<li>
														<a href="my-purchase.php">
															<i class="fa fa-clipboard" aria-hidden="true"></i>
															My Purchase
														</a>
													</li>
													<li>
														<a href="src/providers/Logout.php">
															<i class="fa fa-sign-out"></i> 
															Logout
														</a>
													</li>
												</ul>
											</li>
										<?php else :?>
											<li>
												<a href="login.php" class="btn btn-danger" style="padding: 5px 10px;">LOGIN</a>
											</li>
											<li>
												<a href="register.php" class="btn btn-outline-danger" style="padding: 5px 10px;">SIGN UP</a>
											</li>
										<?php endif; ?>
									</ul>
								</nav>							
							</div>
						</div>
					</div>
				</header>