<?php
    include_once '../TransactionController.php';
    include_once '../TmpFileController.php';
    $transactionCntrl = new TransactionController();
    $tmpFileCntrl = new TmpFileController();

    header('Content-Type: application/json');

    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
    $order_code = isset($_POST['order_code']) ? $_POST['order_code'] : null;
    $order_status = isset($_POST['order_status']) ? $_POST['order_status'] : null;
    $payment_type = isset($_POST['payment_type']) ? $_POST['payment_type'] : null;
    $amount = isset($_POST['amount']) ? $_POST['amount'] : null;

    $transaction_params = array(
        'user_id' => (int)$user_id,
        'transaction_code' => $transactionCntrl->generate_transaction_code(),
        'order_code' => $order_code,
        'order_type' => ORDER_TYPE_PRODUCT,
        'payment_type' => (int)$payment_type,
        'payment_status' => ($payment_type == PAYMENT_TYPE_GCASH) ? PAYMENT_STATUS_VERIFY : PAYMENT_STATUS_UNPAID,
        'amount' =>  (float)$amount
    );

    if ($payment_type == PAYMENT_TYPE_GCASH) {
        $extra_params = array();

        // - gcash no.
        if (isset($_POST['gcash_no'])) {
            $extra_params['gcash_no'] = $_POST['gcash_no'];
        }

        // - receipt
        if (isset($_FILES['receipt'])) {
            $upload_params = array(
                'file' => $_FILES['receipt'],
                'resources_id' => 400,
                'resources' => TMP_UPLOAD_RECEIPT,
            );
            $upload_receipt = $tmpFileCntrl->tmp_file($upload_params);
            $extra_params['receipt_img'] = $upload_receipt['filename'];
        }

        // - reference number
        if (isset($_POST['reference_no'])) {
            $extra_params['reference_no'] = $_POST['reference_no'];
        }

        $transaction_params = array_merge($transaction_params, $extra_params);
    }
    $transactions = $transactionCntrl->create_transaction($transaction_params);

    echo json_encode($transactions);
?>
