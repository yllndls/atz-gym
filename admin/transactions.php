<?php 
    require_once 'header.php'; 

    $transaction_code = isset($_GET['transaction_code']) ? $_GET['transaction_code'] : '';
    $date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
    $date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';
    $order_type = isset($_GET['order_type']) ? $_GET['order_type'] : '';
    $payment_type = isset($_GET['payment_type']) ? $_GET['payment_type'] : '';

    $search_params = array(
        'transaction_code' => $transaction_code,
        'date_from' => $date_from,
        'date_to' => $date_to,
        'order_type' => $order_type, 
        'payment_type' => $payment_type
    );

    $transac_list = $transactionCntrl->transaction_list($search_params);
?>
    <div class="page-wrapper" ng-controller="GymTransactionController" ng-cloak="true">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Transactions</h3>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Search Transactions</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="GET">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Transaction Code</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="transaction_code" value="<?= $transaction_code; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Transaction Date</label>
                                        <div class="col-md-4">
                                            <input type="date" class="form-control" name="date_from" value="<?= $date_from; ?>">
                                        </div>
                                        <div class="col-md-1 text-center">~</div>
                                        <div class="col-md-4">
                                            <input type="date" class="form-control" name="date_to" value="<?= $date_to; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Order Type</label>
                                        <div class="col-md-9">
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="order_type" id="newly" value="membership" <?= $order_type == 'membership' ? 'checked':''; ?>>
                                                <label class="form-check-label" for="newly">Membership</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="order_type" id="renewal" value="product" <?= $order_type == 'product' ? 'checked':''; ?>>
                                                <label class="form-check-label" for="renewal">Product</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Payment Type</label>
                                        <div class="col-md-9">
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="payment_type" id="ongoing" value="2" <?= $payment_type == 2 ? 'checked':''; ?>>
                                                <label class="form-check-label" for="ongoing">Pay at counter</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="payment_type" id="expired" value="1" <?= $payment_type == 1 ? 'checked':''; ?>>
                                                <label class="form-check-label" for="expired">GCash</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3"></label>
                                        <div class="col-md-9">
                                            <button class="btn btn-info btn-rounded pl-4 pr-4">Search</button>
                                            <a href="transactions.php" class="btn btn-rounded pl-4 pr-4">Clear</a>
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
                            <h4 class="card-title">Transaction List</h4>
                            <div class="table-responsive">
                                <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list footable-loaded footable" data-page-size="10">
                                    <thead>
                                        <tr>
                                            <th class="footable-sortable">#</th>
                                            <th class="footable-sortable">Transaction Code</th>
                                            <th class="footable-sortable">Order Type</th>
                                            <th class="footable-sortable">Payment Type</th>
                                            <th class="footable-sortable">Receipt</th>
                                            <th class="footable-sortable">Reference No.</th>
                                            <th>GCash No.</th>
                                            <th class="footable-sortable">Amount Received</th>
                                            <th class="footable-sortable">Payee</th>
                                            <th class="footable-sortable">Received By</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($transac_list['data'] as $key => $list) :?>
                                            <tr class="footable-even">
                                                <td><?= $key + 1; ?></td>
                                                <td><?= $list['transaction_code']; ?></td>
                                                <td><?= $list['order_type']; ?></td>
                                                <td><?= $list['pay_type']; ?></td>
                                                <td>
                                                    <?php if (!empty($list['receipt_img'])) : ?>
                                                        <a href="../public/assets/image/receipt/<?= $list['receipt_img']; ?>" download="GCASH_RECEIPT_<?= $list['transaction_code']; ?>.jpg">
                                                            <span class="mdi mdi-cloud-download"></span>
                                                            <small>Download Receipt</small>
                                                        </a>
                                                    <?php else :?>
                                                        <span>--</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= !empty($list['reference_no']) ? $list['reference_no'] : '--'; ?></td>
                                                <td><?= !empty($list['gcash_no']) ? $list['gcash_no'] : '--'; ?></td>
                                                <td><?= $list['amount_received']; ?></td>
                                                <td><?= $list['fname'].' '.$list['lname']; ?></td>
                                                <td><?= $list['admin_fname'].' '.$list['admin_lname']; ?></td>
                                                <td><?= $list['created']; ?></td>
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
    </div>
<?php require_once 'footer.php'; ?>
    