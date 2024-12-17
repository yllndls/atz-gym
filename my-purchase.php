<?php 
    require_once 'header.php'; 
    $params = array(
        'user_id' => $user_id
    );
    $purchase = $productCntrl->order_lists($params);
?>
    <section class="page-category" ng-controller="GymOrderController">
        <section class="page-heading">
            <div class="title-slide">
                <div class="container">
                    <div class="banner-content slide-container">									
                        <div class="page-title">
                            <h3>MY PLAN</h3>
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
                                <li class="category-2"><a href="#">My Purchase</a></li>								
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <section class="price-table">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-dark">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Order Code</th>
                                        <th scope="col">Total Item</th>
                                        <th scope="col">Total Price</th>
                                        <th scope="col">Order Status</th>
                                        <th scope="col">Payment Status</th>
                                        <th width="10">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($purchase['data'] as $key => $data) :?>
                                        <tr>
                                            <td><?= $key + 1; ?></td>
                                            <td class="text-info"><b><?= $data['order_code']; ?></b></td>
                                            <td><?= $data['total_quantity']; ?></td>
                                            <td><?= $data['total_price']; ?></td>
                                            <td><?= $data['order_status']; ?></td>
                                            <td><?= $data['payment_status']; ?></td>
                                            <td><a class="btn btn-sm btn-info" data-toggle="modal" data-target="#orderDetailsModal" ng-click="orderDetails(<?= htmlspecialchars(json_encode($data)); ?>)">Order details</a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>			
        </div>

        <!-- Modal -->
        <div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" style="background: #7e7e7e;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-dark">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="order in orders_data track by $index">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ order.order_code }}</td>
                                    <td>
                                        <div>
                                            <img ng-src="public/assets/image/product/{{ order.product_photo }}" style="width:50px; height:50px;" alt="">
                                            {{ order.title }}
                                        </div>
                                    </td>
                                    <td> {{ order.quantity }}</td>
                                    <td>{{ order.price }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right">Total Items</td>
                                    <td>{{ totalQuantity }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right">Total Price</td>
                                    <td>{{ totalPrice }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php require_once 'footer.php'; ?>