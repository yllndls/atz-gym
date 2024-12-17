<?php
    include_once '../ProductController.php';
    $productCntrl = new ProductController();

    header('Content-Type: application/json');

    $cart_id = isset($_POST['cart_id']) ? $_POST['cart_id'] : null;
    $result = $productCntrl->cart_remove($cart_id);

    echo json_encode($result);
?>
