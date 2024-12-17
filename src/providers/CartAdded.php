<?php
    include_once '../ProductController.php';
    $productCntrl = new ProductController();

    header('Content-Type: application/json');

    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
    $price = isset($_POST['price']) ? $_POST['price'] : null;
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;

    $validate = $productCntrl->cart_validate($user_id, $product_id);

    $result = array();
    if ($validate['total_count'] == 0) {
        $request = array (
            'user_id' => (int)$user_id,
            'product_id' => (int)$product_id,
            'price' => (float)$price,
            'quantity' => (int)$quantity,
        );

        $added =  $productCntrl->cart_added($request);
        $result = array(
            'success' => true
        );

    }  else {
        $result = array(
            'success' => false
        );
    }

    echo json_encode($result);
?>
