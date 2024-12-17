<?php require_once 'header.php'; ?>
    <section class="page-product" ng-controller="GymOrderController" ng-clock>
        <!--Banner-->
        <section class="page-heading">
            <div class="title-slide">
                <div class="container">
                    <div class="banner-content">									
                        <div class="page-title">
                            <h3>Product listing</h3>
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
                                <li class="category-2"><a href="#">Product cart</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- End Breadcrumbs -->
            <div class="product-cart">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="cart">
                                <div class="cart-table" ng-init="initCart(<?= $user_id; ?>)">
                                    <div class="row-title">
                                        <div class="col-md-5"><span>Item</span></div>
                                        <div class="col-md-2"><span>Price</span></div>
                                        <div class="col-md-2"><span>Quanlity</span></div>
                                        <div class="col-md-2"><span>Total</span></div>
                                        <div class="delete-item col-md-1"><a href="#"><i class="fa fa-times-circle"></i></a></div>
                                    </div>
                                    <div class="row-item" ng-repeat="cart in cart_data track by $index">
                                        <div class="item name-item col-md-5">
                                            <div class="row">
                                                <div class="col-md-4 product-image" style="width:70px; height:70px; margin:0 1rem;">
                                                    <div class="row">
                                                        <img alt="" ng-src="public/assets/image/product/{{ cart.product_photo}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 product-info">
                                                    {{ cart.title }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item price-item col-md-2">
                                            <span class="cart-price">&#8369; {{ cart.price }}</span>
                                        </div>
                                        <div class="item qty-item col-md-2">
                                            <div class="add-to-cart">
                                                <input type="text" class="input-text qty-1"  ng-model="cart.quantity" minlength="1">
                                                <span class="increase-qty">
                                                    <i class="fa fa-sort-up" ng-click="increaseQuantity(cart)"></i>
                                                </span>
                                                <span class="decrease-qty">
                                                    <i class="fa fa-sort-down" ng-click="decreaseQuantity(cart)"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="item price-item col-md-2">
                                            <span class="cart-price">&#8369; {{ cart.price * cart.quantity }}</span>
                                        </div>
                                        <div class="item delete-item col-md-1">
                                            <a href="#" ng-click="deleteToCart(cart)"><i class="fa fa-times-circle"></i></a></div>
                                    </div>

                                    <div class="row-item text-center" ng-if="cart_count == 0">
                                        <h5>NO DATA FOUND</h5>
                                    </div>
                                </div>

                                <div class="product-check-out" ng-if="cart_count > 0">
                                    <div class="col-md-12">
                                        <div class="checkout">                                            
                                            <div class="checkout-row row">
                                                <div class="col-md-6">
                                                    <div class="cart-total">
                                                        <div class="title">Cart Total</div>
                                                        <div class="box">
                                                            <div class="cart-total-item">
                                                                <label>Total Item</label>
                                                                <div class="price">{{ cart_count }}</div>
                                                            </div>
                                                            <div class="cart-total-item order-total">
                                                                <label>Order total price</label>
                                                                <div class="price">&#8369; {{ total_price }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <form ng-submit="checkOutProduct()">
                                                        <div class="cart-total">
                                                            <div class="title">PAYMENT TYPE</div>
                                                            <div class="box">
                                                                <div class="payment-method">
                                                                    <div class="payment-item">
                                                                        <input type="radio" class="radio" name="payment_type" value="0" ng-model="paymentType" ng-change="selectPaymentType(0)">
                                                                        <div class="method">
                                                                            <p>Pay at counter</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="payment-item">
                                                                        <input type="radio" class="radio" name="payment_type" value="1" ng-model="paymentType" ng-change="selectPaymentType(1)">
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
                                                                        <input type="text" class="form-control" id="reference" minlength="5" placeholder="Enter Reference number" name="reference_no" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br />
                                                            <button type="submit" class="button btn-checkout">
                                                                <em class="fa-icon"><i class="fa fa-arrow-right"></i></em>
                                                                <span>CHECK OUT</span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`
    </section>
<?php require_once 'footer.php'; ?>