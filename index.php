<?php 
	require_once 'header.php';

	$condition = array(
		'limit' => 8,
		'status' => PRDCT_STATUS_ON_FLG
	);

	$product = $productCntrl->list($condition);
	$member_info = $membershipCntrl->membership_info(['status' => 1]);
?>
	<!--Banner-->
	<section class="slide-container to-top">
		<div class="ms-fullscreen-template" id="slider1-wrapper">
			<!-- masterslider -->
			<div class="master-slider ms-skin-default" id="masterslider-index">
				<div class="ms-slide slide-1" data-delay="0">
					<div class="slide-pattern"></div>
					<img src="images/blank.gif" data-src="public/assets/image/system/slider_1.jpg" alt="lorem ipsum dolor sit"/>
					<h3 class="ms-layer hps-title1" style="left:101px"
						data-type="text"
						data-ease="easeOutExpo"
						data-delay="1000"
						data-duration="0"
						data-effect="skewleft(30,80)"
					>
						ATZ Fitness Gym
					</h3>																												
					<h3 class="ms-layer hps-title3" style="left:95px"
						data-type="text"
						data-delay="1900"
						data-duration="0"
						data-effect="rotate3dtop(-100,0,0,40,t)"
						data-ease="easeOutExpo"
					>
						Make You Be The Fighter
					</h3>
					
					<h3 class="ms-layer hps-title4" style="left:101px"
						data-type="text"
						data-delay="2500"
						data-duration="0"
						data-effect="rotate3dtop(-100,0,0,18,t)"
						data-ease="easeOutExpo"
					>
						Try A Free Class
					</h3>
				</div>
				<div class="ms-slide slide-2" data-delay="0">
					<div class="slide-pattern"></div>							  
					<img src="images/blank.gif" data-src="public/assets/image/system/slider_2.jpg" alt="lorem ipsum dolor sit"/>
					<h3 class="ms-layer hps-title1" style="left:101px"
						data-type="text"
						data-ease="easeOutExpo"
						data-delay="1000"
						data-duration="0"
						data-effect="skewleft(30,80)">
						Athlete Fitness Club
					</h3>																												
					<h3 class="ms-layer hps-title3" style="left:95px"
						data-type="text"
						data-delay="1900"
						data-duration="0"
						data-effect="rotate3dtop(-100,0,0,40,t)"
						data-ease="easeOutExpo"
					>
						Make You Be The Fighter
					</h3>
					
					<h3 class="ms-layer hps-title4" style="left:101px"
						data-type="text"
						data-delay="2500"
						data-duration="0"
						data-effect="rotate3dtop(-100,0,0,18,t)"
						data-ease="easeOutExpo"
					>
						Try A Free Class
					</h3>
				</div>	
				
				<div class="ms-slide slide-3" data-delay="0">
					<div class="slide-pattern"></div>							  
					<img src="images/blank.gif" data-src="public/assets/image/system/slider_3.jpg" alt="lorem ipsum dolor sit"/>
					<h3 class="ms-layer hps-title1" style="left:101px"
						data-type="text"
						data-ease="easeOutExpo"
						data-delay="1000"
						data-duration="0"
						data-effect="skewleft(30,80)"
					>
						Athlete Fitness Club
					</h3>																												
					<h3 class="ms-layer hps-title3" style="left:95px"
						data-type="text"
						data-delay="1900"
						data-duration="0"
						data-effect="rotate3dtop(-100,0,0,40,t)"
						data-ease="easeOutExpo"
					>
						Make You Be The Fighter
					</h3>
					
					<h3 class="ms-layer hps-title4" style="left:101px"
						data-type="text"
						data-delay="2500"
						data-duration="0"
						data-effect="rotate3dtop(-100,0,0,18,t)"
						data-ease="easeOutExpo"
					>
						Try A Free Class
					</h3>
				</div>
			</div>
			<!-- end of masterslider -->
			<div class="to-bottom" id="to-bottom"><i class="fa fa-angle-down"></i></div>
		</div>
	</section>
				
	<div class="contents-main" id="contents-main">						
		<!--Price Table-->
		<section class="price-table">
			<div class="container">
				<div class="row">
					<div class="price-table-title col-md-12 col-sm-12 col-xs-12">
						<h2>JOIN OUR MEMBERSHIP PROGRAM</h2>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="price-contents">
							<?php foreach($member_info['data'] as $key => $info) :?>
								<div class="col-md-4 col-sm-12 col-xs-12">
									<div class="price-tb">
										<div class="col-md-12 price-table-content">
											<div class="price-table-img">
												<img alt="" src="public/assets/image/system/feature_3.png">
											</div>
											<div class="price-table-text">
												<h3>JOIN NOW</h3>
												<h2><?= $info['title']; ?></h2>
												<div class="border-bottom"></div>
												<p><?= $info['description']; ?></p>
												<div class="price">
													<span>&#8369; <?= $info['price']; ?></span>
												</div>
											</div>
										</div>
										<div class="col-md-12 price-list">
											<div class="price-table-1">
												<ul>
													<li class="icon"><i class="fa fa-calendar-o"></i></li>
													<li>Entry days: <?= $info['entry_days']; ?></li>
												</ul>
												<ul>
													<li class="icon"><i class="fa fa-clock-o"></i></li>
													<li>Entry time: <?= $info['entry_time']; ?></li>
												</ul>
												<ul>
													<li class="icon"><i class="fa fa-clock-o"></i></li>
													<li>Duration: <?= $info['days_duration']; ?> Days</li>
												</ul>										
											</div>
											<div class="plan">
												<?php if (isset( $_SESSION['user_id'])) :?>
													<a href="membership.php?plan_id=<?= $info['plan_id']; ?>">
														PURCHASE PLAN
													</a>
												<?php else : ?>
													<a href="login.php">
														PURCHASE PLAN
													</a>
												<?php endif; ?>
											</div>										
										</div>
									</div>
								</div>
							<?php endforeach;?>
						</div>
					</div>
				</div>
			</div>
		</section>	
		
		<!--New Products-->
		<section class="new-product scroll-to" ng-controller="GymOrderController">
			<div class="container">
				<div class="row">
					<div class="title-name">
						<h4>New Product</h4>
					</div>
					<?php foreach($product['list'] as $key => $list) :?>
						<!-- stored id on list -->
						<?php
							$list['user_id'] = $user_id;
							$list['get_qty'] = DEFAULT_QUANTITY;
							$list['is_verify_flg'] = isset($detail['is_verify_flg']) ? $detail['is_verify_flg'] : 0;
						?>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="product-image-wrapper">
								<div class="product-content">
									<div class="product-image">
										<img alt="" src="public/assets/image/product/<?= $list['product_photo']; ?>">
									</div>
									<div class="info-products">
										<div class="product-name">
											<a href="javascript:void(0)"><?= $list['title']; ?></a>
											<div class="product-bottom"></div>
										</div>
										<div class="price-box">																										
											<span class="special-price">&#8369; <?= number_format($list['price']); ?></span>
										</div>
										<div class="actions">
											<ul>
												<li><a href="product-detail.php?id=<?= $list['product_code'] ?>"><i class="fa fa-info"></i></a></li>
												<!-- <li><a href="#"><i class="fa fa-star"></i></a></li> -->
											</ul>
										</div>
									</div>
								</div>
								<a class="arrows" ng-click="addToCart(<?= htmlspecialchars(json_encode($list)); ?>)"><i class="fa fa-shopping-cart"></i></a>										
							</div>
						</div>
					<?php endforeach; ?>					
				</div>						
			</div>
		</section>
		
		<!--  Fit & Strong  -->
		<section class="fit-strong">
			<div class="container">
				<div class="row">
					<div class="col-md-4 col-sm-6 col-xs-12">
						<div class="fit-strong-left">												
							<div class="fit-strong-top">
								<h3 class="fit-strong-text">Keep your body</h3>
								<h2 class="fit-strong-text">Fit & Strong</h2>
								<p class="fit-strong-sub">Phasellus fermentum in, dolor. Pellentesque facilisis. Nulla imperdiet sit amet magna.
								Vestibulum dapibus, mauris nec malesuada fames ac turpis velit Phasellus fermentum in, dolor. Pellentesque facilisis. </p>
							</div>
							<div class="fit-strong-bottom">
								<div class="fit-background"></div>
								<div class="carousel-image">
									<div id="carousel-image" class="owl-carousel" data-plugin-options='{"singleItem":true,"autoPlay":false,"autoHeight":true, "mouseDrag": false}'>
										<div class="caroussel-slide">
												<img src="images/onepage/fit-2.jpg" alt="">
										</div>
										<div class="caroussel-slide">
												<img src="images/onepage/fit-2.jpg" alt="">
										</div>
										<div class="caroussel-slide">
												<img src="images/onepage/fit-2.jpg" alt="">
										</div>
									</div>												
								</div>
								<div class="owl-controls clickable">
									<div class="owl-pagination">
										<div class="owl-page active" data-page='0'><span class=""></span></div>
										<div class="owl-page" data-page='1'><span class=""></span></div>
										<div class="owl-page" data-page='2'><span class=""></span></div>
									</div>
								</div>
								<div class="carousel-text">
									<div id="carousel-text" class="owl-carousel" data-plugin-options='{"singleItem":true,"autoPlay":false,"autoHeight":true, "mouseDrag": false}' data-pager='owl-page'>
										<div class="slide-caption">
											<h4 class="caption-title">Try your first training for free</h4>
											<p class="caption-slide">Aliquam purus. Quisque lorem tortor fringilla sed, vestibulum id. Nulla ipsum dolor lacus, suscipit adipiscing. Cum sociis natoque </p>
										</div>
										<div class="slide-caption">
											<h4 class="caption-title">Try your first training for free</h4>
											<p class="caption-slide">Aliquam purus. Quisque lorem tortor fringilla sed, vestibulum id. Nulla ipsum dolor lacus, suscipit adipiscing. Cum sociis natoque </p>
										</div>
										<div class="slide-caption">
											<h4 class="caption-title">Try your first training for free</h4>
											<p class="caption-slide">Aliquam purus. Quisque lorem tortor fringilla sed, vestibulum id. Nulla ipsum dolor lacus, suscipit adipiscing. Cum sociis natoque </p>
										</div>												
									</div>												
								</div>												
							</div>							
						</div>							
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<div class="fit-strong-right">
							<div class="img-box-right" id="boxOpenTime">
								<img class="img-box" src="public/assets/image/system/fit-4.png" alt=""/>
								<div class="open-hour">
									<i class="fa fa fa-clock-o"></i>
									<div class="open-hours-title">
										<h4>Opening</h4>
										<p>Hours</p>
									</div>
								</div>
								<div class="img-box-right-border"></div>
							</div>
							<div class="bottomright"></div>
							<div class="text-box">
								<p>Vitae adipiscing turpis. Aenean ligula nibh, molestie id viverra a, dapibus at dolor.</p>
								<h5>From monday to friday</h5>							
								<span class="open-hours">8 <sup>A.M</sup> - 8 <sup>P.M</sup></span>
								<h5>Saturday and sunday</h5>
								<span class="open-hours">7 <sup>A.M</sup> - 9 <sup>P.M</sup></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
<?php require_once 'footer.php'; ?>