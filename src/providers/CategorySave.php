<?php
    session_start();

    include_once '../ProductController.php';
    $productCntrl = new ProductController();

    $params = array(
        'category_name' => isset($_POST['category_name']) ? $_POST['category_name'] : ''
    );
    $result = $productCntrl->createCategory($params);

    if (isset($result['success'])) {
        $_SESSION['result'] = $result;
        $_SESSION['timestamp'] = time();
        $_SESSION['title'] = 'SUCCESS!';
        $_SESSION['message'] = 'Category successfully created';
        $_SESSION['message_type'] = 'success';

        header('Location: ../../admin/product-category.php'); 
        exit;
    }
    
?>