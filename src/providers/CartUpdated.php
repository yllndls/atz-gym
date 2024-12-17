<?php
    include_once '../ProductController.php';
    $productCntrl = new ProductController();

    header('Content-Type: application/json');

    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;

    $request = array (
        'user_id' => (int)$user_id,
        'product_id' => (int)$product_id,
        'quantity' => (int)$quantity,
    );

    $result = $productCntrl->cart_update($request);

    echo json_encode($result);
?>
