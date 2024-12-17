<?php
    include_once '../ProductController.php';
    $productCntrl = new ProductController();

    header('Content-Type: application/json');

    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
    $details = $productCntrl->cart_list($user_id);

    echo json_encode($details);
?>
