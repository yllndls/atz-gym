<?php
    include_once '../ProductController.php';
    $productCntrl = new ProductController();

    header('Content-Type: application/json');

    // Read the raw POST data (as JSON)
    $data = json_decode(file_get_contents('php://input'), true); 

    $cart_id = isset($data['cart_id']) ? $data['cart_id'] : null;
    $user_id = isset($data['user_id']) ? $data['user_id'] : null;
    $product_id = isset($data['product_id']) ? $data['product_id'] : null;
    $price = isset($data['price']) ? $data['price'] : null;
    $order_code = isset($data['order_code']) ? $data['order_code'] : null;
    $order_status = isset($data['order_status']) ? $data['order_status'] : null;
    $payment_status = isset($data['payment_type']) ? $data['payment_type'] : null;
    $quantity = isset($data['quantity']) ? $data['quantity'] : null;
    $product_qty = isset($data['product_qty']) ? $data['product_qty'] : null;

    $order_params = array(
        'user_id' => (int)$user_id,
        'product_id' => (int)$product_id,
        'quantity' => (int)$quantity,
        'price' => (float)$price,
        'order_code' => $order_code,
        'order_status' => (int)$order_status,
        'payment_status' => (int)$payment_status
    );

    $orders = $productCntrl->order_added($order_params);
    if ($orders['success']) {
        $product_params = array(
            'product_id' => (int)$product_id,
            'quantity' => ($product_qty - $quantity)
        );
        $product_update = $productCntrl->update_product_quantity($product_params);
        $removed_cart = $productCntrl->cart_remove($cart_id);

        $response = array(
            'success' => true
        );
    } else {
        $response = array(
            'success' => false
        );
    }

    echo json_encode($response);
?>
