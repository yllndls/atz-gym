<?php
    include_once '../MembershipController.php';
    include_once '../TransactionController.php';
    $membershipCntrl = new MembershipController();
    $transactionCntrl = new TransactionController();

    header('Content-Type: application/json');

    $membership_id = isset($_POST['membership_id']) ? $_POST['membership_id'] : null;
    $received_by = isset($_POST['received_by']) ? $_POST['received_by'] : null;
    $starting_date = isset($_POST['starting_date']) ? $_POST['starting_date'] : null;
    $expiration_date = isset($_POST['expiration_date']) ? $_POST['expiration_date'] : null;
    $amount_received = isset($_POST['amount_received']) ? $_POST['amount_received'] : null;

    // - membership
    $membership_params = array(
        'membership_id' => $membership_id,
        'starting_date' => $starting_date,
        'expiration_date' => $expiration_date,
        'payment_status' => PAYMENT_STATUS_PAID,
    );
    $update_membership = $membershipCntrl->update_membership($membership_params);

    // - transactions
    $transaction_params = array(
        'order_code' => $membership_id,
        'payment_status' => PAYMENT_STATUS_PAID,
        'amount_received' => $amount_received,
        'received_by' => $received_by,
    );
    $update_transaction = $transactionCntrl->update_transaction($transaction_params);

    $results = array(
        'success' => (!!$update_membership['success'] && !!$update_membership['success']),
        'membership' => $update_membership['success'],
        'transaction' => $update_membership['success'],
    );

    echo json_encode($update_membership);
?>
