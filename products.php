<?php 
    require_once 'header.php';

    $title = isset($_GET['title']) ? $_GET['title'] : '';
    $category = isset($_GET['category']) ? $_GET['category'] : '';
    $price_min = isset($_GET['price_min']) ? $_GET['price_min'] : '';
    $price_max = isset($_GET['price_max']) ? $_GET['price_max'] : '';


    $condition = array(
        'title' => $title,
        'category' => $category,
        'price_min' => $price_min,
        'price_max' => $price_max,
		'status' => PRDCT_STATUS_ON_FLG
	);
    $product = $productCntrl->list($condition);
?>
    <section class="page-product">
        <section class="page-heading">
            <div class="title-slide">
                <div class="container">
                    <div class="banner-content">									
                        <div class="page-title">
                            <h3>Products</h3>
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
                                <li class="home"><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                                <li><span>/</span></li>
                                <li class="category-2"><a href="#">Product listing</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="product-list" ng-controller="GymOrderController">
                <div class="container">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="toolbar">
                                <p class="amount">
                                    <strong>SHOWING ALL <?= $product['count']; ?> RESULTS</strong>
                                </p>
                            </div>
                            <div class="row">
                                <?php foreach($product['list'] as $key => $list) :?>
                                    <!-- stored id on list -->
                                    <?php
                                        $list['user_id'] = $user_id;
                                        $list['get_qty'] = DEFAULT_QUANTITY;
                                        $list['is_verify_flg'] = isset($detail['is_verify_flg']) ? $detail['is_verify_flg'] : 0;
                                    ?>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
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
                                            <a class="arrows quickview" ng-click="addToCart(<?= htmlspecialchars(json_encode($list)); ?>)"><i class="fa fa-shopping-cart"></i></a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="product-filter">
                                <h3 class="title">SEARCH PRODUCTS</h3>
                                <hr>
                                <form action="" method="GET">
                                    <div class="form-group">
                                        <label class="control-label">TITLE</label>
                                        <input type="text" class="form-control" name="title" value="<?= $title; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">CATEGORY</label>
                                        <select class="form-control" name="category">
                                            <option selected value="">--</option>
                                            <?php foreach($productCntrl->category() as $data) : ?>
                                                <option value="<?= $data['id']; ?>" <?= $category == $data['id'] ? 'selected': ''?>><?= $data['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-12">PRICE RANGE</label>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" name="price_min" min="1" value="<?= $price_min; ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" name="price_max" min="1" value="<?= $price_max; ?>">
                                        </div>
                                    </div>
                                    <button class="btn btn-block" style="background:#000;">SEARCH</button>
                                    <a href="products.php" class="btn" style="width:100%; margin-top:15px;">RESET</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php require_once 'footer.php'; ?>