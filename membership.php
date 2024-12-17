<?php 
    require_once 'header.php'; 
    $params = array(
        'status' => 1
    );
    if (isset($_GET['plan_id'])) {
        $params = array_merge($params, array('plan_id' => $_GET['plan_id']));
    }
    $member_info = $membershipCntrl->membership_info($params);
?>
    <section class="page-category">
        <section class="page-heading">
            <div class="title-slide">
                <div class="container">
                    <div class="banner-content slide-container">									
                        <div class="page-title">
                            <h3>MEMBERSHIP PLAN</h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="page-content">					
            <!-- Breadcrumbs -->
            <div class="breadcrumbs">
                <div class="container">
                    <div class="row">
                        <div class="col-md-9">
                            <ul>
                                <li class="home"><a href="#"><i class="fa fa-home"></i> Home</a></li>
                                <li><span>/</span></li>
                                <li class="category-2"><a href="#">Membership</a></li>								
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <section class="price-table" ng-controller="GymTransactionController" ng-cloak="true">
                <div class="container">
                    <div class="row">
                        <?php if (isset($_GET['plan_id']) && !empty($_GET['plan_id'])) : ?>

                            <div class="product-check-out">
                                <div class="col-md-12">
                                    <div class="checkout">                                            
                                        <div class="checkout-row row">
                                            <div class="col-md-6">
                                                <div class="cart-total"> 
                                                    <div class="title">MEMBER DETAILS</div>
                                                    <div class="box">
                                                        <div class="cart-total-item">
                                                            <label>Name: </label>
                                                            <div class="price">
                                                                <?= !empty($detail['fname']) ? $detail['fname'] : '';?>
                                                                <?= !empty($detail['lname']) ? $detail['lname'] : '';?>
                                                            </div>
                                                        </div>
                                                        <div class="cart-total-item">
                                                            <label>Address</label>
                                                            <div class="price"><?= !empty($detail['address']) ? $detail['address'] : '';?></div>
                                                        </div>
                                                        <div class="cart-total-item">
                                                            <label>Email</label>
                                                            <div class="price"><?= !empty($detail['email']) ? $detail['email'] : '';?></div>
                                                        </div>
                                                        <div class="cart-total-item order-total">
                                                            <label>Contact No. </label>
                                                            <div class="price"><?= !empty($detail['contact']) ? $detail['contact'] : '';?></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="cart-total"> 
                                                    <div class="title">MEMBERSHIP PLAN</div>
                                                    <div class="box">
                                                        <div class="cart-total-item">
                                                            <label>Membership Plan ID</label>
                                                            <div class="price"><?= isset($member_info['data'][0]) ? $member_info['data'][0]['plan_id'] : '';?></div>
                                                        </div>
                                                        <div class="cart-total-item">
                                                            <label>Duration</label>
                                                            <div class="price"><?= isset($member_info['data'][0]) ? $member_info['data'][0]['days_duration'] : '';?> Days</div>
                                                        </div>
                                                        <div class="cart-total-item order-total">
                                                            <label>Price</label>
                                                            <div class="price">&#8369; <?= isset($member_info['data'][0]) ? $member_info['data'][0]['price'] : '';?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <form name="membershipForm" ng-submit="submitAvailMembership($event)">
                                                    <input type="hidden" name="is_profile_flg" value="<?= !empty($detail['is_profile_flg']) ? $detail['is_profile_flg'] : '';?>">
                                                    <input type="hidden" name="user_id" value="<?= !empty($detail['id']) ? $detail['id'] : '';?>">
                                                    <input type="hidden" name="plan_id" value="<?= isset($member_info['data'][0]) ? $member_info['data'][0]['plan_id'] : '';?>">
                                                    <input type="hidden" name="membership_amount" value="<?= isset($member_info['data'][0]) ? $member_info['data'][0]['price'] : '';?>">
                                                    <input type="hidden" name="membership_status" value="<?= $membership_expired == EXPIRED_FLAG_OFF ? EXPIRED_FLAG_OFF : EXPIRED_FLAG_ON; ?>">
                                                    <?php if ($membership_expired == EXPIRED_FLAG_ON) :?>
                                                        <input type="hidden" name="is_expired_flg" value="1">
                                                    <?php endif; ?>
                                                    <div class="cart-total">
                                                        <div class="title">PAYMENT TYPE</div>
                                                        <div class="box">
                                                            <div class="payment-method">
                                                                <div class="payment-item">
                                                                    <input type="radio" class="radio" name="payment_type" value="0" ng-model="paymentType" ng-change="selectPaymentType()">
                                                                    <div class="method">
                                                                        <p>Pay at counter</p>
                                                                    </div>
                                                                </div>
                                                                <div class="payment-item">
                                                                    <input type="radio" class="radio" name="payment_type" value="1" ng-model="paymentType" ng-change="selectPaymentType()">
                                                                    <div class="method">
                                                                        <p>GCash</p>
                                                                        <a href="">09692375759</a>
                                                                        <p class="text-primary">
                                                                            Make your payment directly into our
                                                                            <a href="">GCash account ~ show QR Code</a>. Please provide a receipt file or reference no.
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br />
                                                            <div class="payment_gcash" ng-show="!!gcashPaymentFlg">
                                                                <div class="form-group">
                                                                    <label for="gcash_no">GCash No.</label>
                                                                    <input type="number" class="form-control" id="gcash_no" name="gcash_no" minlength="6" maxlength="11" placeholder="Enter GCash No."/>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="receipt">GCash Receipt</label>
                                                                    <input type="file" class="form-control" id="receipt" name="receipt"/>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="reference">GCash Reference No.</label>
                                                                    <input type="text" class="form-control" id="reference" placeholder="Enter Reference No." name="reference_no" minlength="6"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br />
                                                        <button type="submit" class="button btn-checkout">
                                                            <em class="fa-icon"><i class="fa fa-arrow-right"></i></em>
                                                            <span>AVAIL NOW</span>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        <?php else : ?>
                        
                            <div class="col-md-12">
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

                        <?php endif; ?>
                    </div>
                </div>
            </section>			
        </div>
    </section>
<?php require_once 'footer.php'; ?>