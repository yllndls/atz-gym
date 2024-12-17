<?php 
    require_once 'header.php'; 

    $order_code = isset($_GET['order_code']) ? $_GET['order_code'] : '';
    $order_status = isset($_GET['order_status']) ? $_GET['order_status'] : '';

    $params = array(
        'order_code' => $order_code,
        'order_status' => $order_status
    );
    $order_list = $productCntrl->order_lists($params);
?>
    <div class="page-wrapper" ng-controller="GymOrderController" ng-cloak="true">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Orders</h3>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Search Orders</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="GET">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Order Code</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="order_code" value="<?= $order_code; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Order Status</label>
                                        <div class="col-md-9">
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="order_status" id="Checkout" value="1" <?= $order_status == 1 ? 'checked':''; ?>>
                                                <label class="form-check-label" for="Checkout">Checkout</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="order_status" id="pickup" value="2" <?= $order_status == 2 ? 'checked':''; ?>>
                                                <label class="form-check-label" for="pickup">Pickup</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="order_status" id="complete" value="3" <?= $order_status == 3 ? 'checked':''; ?>>
                                                <label class="form-check-label" for="complete">Completed</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="order_status" id="Cancelled" value="4" <?= $order_status == 4 ? 'checked':''; ?>>
                                                <label class="form-check-label" for="Cancelled">Cancelled</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3"></label>
                                        <div class="col-md-9">
                                            <button class="btn btn-info btn-rounded pl-4 pr-4">Search</button>
                                            <a href="orders.php" class="btn btn-rounded pl-4 pr-4">Clear</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Order List</h4>
                            <div class="table-responsive">
                                <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list footable-loaded footable" data-page-size="10">
                                    <thead>
                                        <tr>
                                            <th class="footable-sortable">#</th>
                                            <th class="footable-sortable">User</th>
                                            <th class="footable-sortable">Order Code</th>
                                            <th class="footable-sortable">Total Item</th>
                                            <th class="footable-sortable">Total Price</th>
                                            <th class="footable-sortable">Order Status</th>
                                            <th class="footable-sortable">Payment Status</th>
                                            <th class="footable-sortable">Date</th>
                                            <th class="footable-sortable"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($order_list['data'] as $key => $data) :?>
                                            <tr class=" <?= $data['order_stats_num'] == 4 ? 'bg_expired':'bg_ongoing'; ?>">
                                                <td><?= $key + 1; ?></td>
                                                <td>
                                                    <a href="javascript:void(0)">
                                                        <img src="../public/assets/image/profile/<?= $data['profile_img']; ?>" alt="user" class="img-circle" style="width:40px; height:40px;"> 
                                                        <?= $data['fname'].' '.$data['lname']; ?>
                                                    </a>
                                                </td>
                                                <td class="text-info"><b><?= $data['order_code']; ?></b></td>
                                                <td><?= $data['total_quantity']; ?></td>
                                                <td><?= $data['total_price']; ?></td>
                                                <td><?= $data['order_status']; ?></td>
                                                <td><?= $data['payment_status']; ?></td>
                                                <td><?= $data['created']; ?></td>
                                                <td>
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-success" data-toggle="modal" data-target="#adminOrderDetails" ng-click="adminOrderDetails(<?= htmlspecialchars(json_encode($data)); ?>)">
                                                        <i class="mdi mdi-pencil"></i> Check Order
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="adminOrderDetails" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="adminOrderDetailsLabel">Order Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-2 text-center">
                                                        <img ng-src="../public/assets/image/profile/{{ arr_order_data.profile_img }}" alt="user" class="img-circle" style="width:50px; height:50px;">     
                                                    </div>
                                                    <div class="col-md-10">
                                                        <h5 class="m-0 p-0">{{ arr_order_data.fname }} {{ arr_order_data.lname }}</h5>
                                                        <small>{{ arr_order_data.address }}</small><br/>
                                                        <code>{{ arr_order_data.email }}</code><br/>
                                                        <code>{{ arr_order_data.contact }}</code>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3" ng-if="arr_order_data.payment_type == 1">
                                    <div class="card-body">
                                        <div ng-if="arr_order_data.receipt_img">
                                            <a href="../public/assets/image/receipt/{{ arr_order_data.receipt_img }}" download="GCASH_RECEIPT_{{ arr_order_data.transaction_code }}.jpg">
                                                <div class="row">
                                                    <div class="col-md-2 text-center">
                                                        <span class="mdi mdi-file-cloud" style="font-size:40px;"></span>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <h5 class="m-0 p-0">GCash ~ Receipt</h5>
                                                        <p>{{ arr_order_data.gcash_no }}</p>
                                                        <small>
                                                            <i class="mdi mdi-cloud-download"></i> 
                                                            Download receipt
                                                        </small>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                        <div ng-if="arr_order_data.reference_no">
                                            <h5>GCash ~ Reference No.</h5>
                                            <code>{{ arr_order_data.reference_no }}</code>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <table class="table table-bordered">
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
                                            <img ng-src="../public/assets/image/product/{{ order.product_photo }}" style="width:50px; height:50px;" alt="">
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

                        <div class="action_wrapper">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col" ng-if="arr_order_data.order_stats_num == 1">
                                        <button type="button" class="btn btn-info" ng-click="orderChangeStatus(2,2)">Received Order</button>
                                    </div>
                                    <div class="col" ng-if="arr_order_data.order_stats_num < 2">
                                        <button type="button" class="btn btn-danger" ng-click="orderChangeStatus(4,0)">Cancelled</button>
                                    </div>
                                    <div class="col" ng-if="arr_order_data.order_stats_num == 2">
                                        <button type="button" class="btn btn-success" ng-click="orderChangeStatus(3,2)">Completed</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require_once 'footer.php'; ?>
    