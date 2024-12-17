<?php
    session_start();

    include_once '../ProductController.php';
    include_once '../TransactionController.php';
    $productCntrl = new ProductController();
    $transactionCntrl = new TransactionController();

    header('Content-Type: application/json');

    $order_code = isset($_POST['order_code']) ? $_POST['order_code'] : null;
    $order_status = isset($_POST['order_status']) ? $_POST['order_status'] : null;
    $payment_status = isset($_POST['payment_status']) ? $_POST['payment_status'] : null;
    $amount_recieved = isset($_POST['amount_recieved']) ? $_POST['amount_recieved'] : null;

    $stats_request = array(
        'order_code' => $order_code,
        'order_status' => (int) $order_status,
        'payment_status' => (int) $payment_status,
    );
    $update_stats = $productCntrl->update_order_status($stats_request);

    if ($update_stats['success']) {
        $transaction_params = array(
            'order_code' => $order_code,
            'payment_status' => (int) $payment_status,
            'amount_received' =>  $amount_recieved,
            'received_by' => 1,
        );
        $update_transaction = $transactionCntrl->update_transaction($transaction_params);
    }

    echo json_encode($update_stats);
?>
