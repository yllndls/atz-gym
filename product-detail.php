<?php 
    require_once 'header.php';

     // - set product detail
     if (isset($_GET['id'])) {
        $search_params['product_code'] = $_GET['id'];
        $product = $productCntrl->list($search_params);
        
        $detail = isset($product['list'][0]) ? $product['list'][0] : array(); 
        $detail['user_id'] = $user_id;
		$detail['get_qty'] = DEFAULT_QUANTITY;
        $detail['is_verify_flg'] = isset($detail['is_verify_flg']) ? $detail['is_verify_flg'] : 0;
    }
?>
    <section class="page-product">
        <section class="page-heading">
            <div class="title-slide">
                <div class="container">
                    <div class="banner-content">									
                        <div class="page-title">
                            <h3>Product DETAILS</h3>
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
                                <li class="home"><a href="products.php"><i class="fa fa-home"></i> List</a></li>
                                <li><span>/</span></li>
                                <li class="category-2"><a href="#">Product Details</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="product-detail" ng-controller="GymOrderController">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="product-view">
                                <div class="product-essential col-md-12">
                                    <div class="product-img-box col-md-6">
                                        <a href="#"><img alt="" src="public/assets/image/product/<?= $detail['product_photo']; ?>" style="width: 570px; height: 570px; object-fit: fill;"></a>
                                    </div>
                                    <div class="product-shop col-md-6">
                                        <div class="product-name">
                                            <h1><?= $detail['title']; ?></h1>
                                        </div>
                                        <div class="meta-box">
                                            <div class="price-box">																										
                                                <span class="special-price">&#8369; <?= $detail['price']; ?></span>
                                            </div>
                                            <!-- <div class="rating-box">
                                                <div class="rating">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div> -->
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="short-description"><?= $detail['description']; ?></div>
                                        <div class="add-to-box">
                                            <!-- <div class="add-to-cart">
                                                <input type="text" class="input-text qty-1" title="Qty" value="1" maxlength="12" id="qty" name="qty">
                                                <span class="increase-qty"><i class="fa fa-sort-up"></i></span>
                                                <span class="decrease-qty"><i class="fa fa-sort-down"></i></span>
                                            </div> -->
                                            <button class="button btn-cart" ng-click="addToCart(<?= htmlspecialchars(json_encode($detail)); ?>)">
                                                <em class="fa-icon"><i class="fa fa-shopping-cart"></i></em>
                                                <span>Add Cart</span>
                                            </button>
                                        </div>

                                        <div class="tags-list">
                                            <label>Category</label><span>:</span>
                                            <ul>
                                                <li><a href="javascript:void(0)"><?= $detail['category']; ?></a></li>
                                            </ul>
                                        </div>
                                        <div class="tags-list">
                                            <label>Quantity</label><span>:</span>
                                            <ul>
                                                <li><a href="javascript:void(0)" style="background:#ec3642; color:#fff;"><?= $detail['quantity']; ?></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div id="tabs" class="product-collateral ui-tabs ui-widget ui-widget-content ui-corner-all">
                                    <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
                                        <li class="ui-state-default ui-corner-top ui-tabs-active" role="tab" tabindex="0" aria-controls="tabs-2" aria-labelledby="ui-id-2" aria-selected="true" aria-expanded="true"><a href="#tabs-2" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2">Reviews</a></li>
                                    </ul>
                                    <div id="tabs-2" class="box-collateral ui-tabs-panel ui-widget-content ui-corner-bottom" aria-labelledby="ui-id-2" role="tabpanel" aria-hidden="false" style="display: block;">
                                        <p>Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor. Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. </p>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php require_once 'footer.php'; ?>