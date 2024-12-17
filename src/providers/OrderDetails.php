<?php
    include_once '../ProductController.php';
    $productCntrl = new ProductController();

    header('Content-Type: application/json');

    $order_code = isset($_POST['order_code']) ? $_POST['order_code'] : null;
    $details = $productCntrl->order_details($order_code);

    echo json_encode($details);
?>
