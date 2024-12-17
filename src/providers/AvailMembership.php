<?php
    include_once '../MembershipController.php';
    include_once '../TransactionController.php';
    include_once '../TmpFileController.php';
    $membershipCntrl = new MembershipController();
    $transactionCntrl = new TransactionController();
    $tmpFileCntrl = new TmpFileController();

    header('Content-Type: application/json');

    $results = array();

    $set_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
    $is_expired_flg = isset($_POST['is_expired_flg']) ? $_POST['is_expired_flg'] : null;
    $validate_params = array(
        'user_id' => (int) $set_id
    );

    // - reverse validation
    if ($is_expired_flg == EXPIRED_FLAG_ON) {
        $validate_params = array_merge($validate_params, ['is_expired_flg' => EXPIRED_FLAG_OFF]);
    }

    $validate_membership = $membershipCntrl->membership($validate_params);
    if ($validate_membership['total_count'] == 0) {
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
        $plan_id = isset($_POST['plan_id']) ? $_POST['plan_id'] : null;
        $membership_status = isset($_POST['membership_status']) ? $_POST['membership_status'] : null;
        $membership_amount = isset($_POST['membership_amount']) ? $_POST['membership_amount'] : null;
        $payment_type = isset($_POST['payment_type']) ? (int)$_POST['payment_type'] : null;

        // - membership process
        $create_params = array(
            'user_id' => $user_id,
            'plan_id' => $plan_id,
            'membership_code' => $membershipCntrl->generate_membership_code(),
            'membership_status' => (int)$membership_status,
            'is_expired_flg' => EXPIRED_FLAG_OFF,
            'membership_flg' => MEMBERSHIP_FLAG_ON,
            'payment_status' => ($payment_type == PAYMENT_TYPE_GCASH) ? PAYMENT_STATUS_VERIFY : PAYMENT_STATUS_UNPAID,
        );
        $create_membership = $membershipCntrl->create_membership($create_params);

        // - transaction process
        $transaction_params = array(
            'user_id' => $user_id,
            'transaction_code' => $transactionCntrl->generate_transaction_code(),
            'order_code' => $create_membership['membership_id'],
            'order_type' => ORDER_TYPE_MEMBERSHIP,
            'payment_type' => $payment_type,
            'payment_status' => ($payment_type == PAYMENT_TYPE_GCASH) ? PAYMENT_STATUS_VERIFY : PAYMENT_STATUS_UNPAID,
            'amount' => $membership_amount
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
                    'resources_id' => $create_membership['membership_id'],
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

        $results = array(
            'success' => true,
            'membership' => isset($create_membership['success']) ? $create_membership['success'] : false,
            'transaction' => isset($transactions['success']) ? $transactions['success'] : false,
            'upload_receipt' => isset($upload_receipt['success']) ? $upload_receipt['success'] : false,
            'message' => 'Successfully avail your membership, please visit our gym facilities to validate your membership thank you!'
        );

    } else {
        $results = array(
            'success' => false,
            'message' => 'You already avail membership plan!'
        );
    }

    echo json_encode($results);
?>
