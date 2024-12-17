<?php
    session_start();

    include_once '../ProductController.php';
    $productCntrl = new ProductController();

    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
    $product_code = isset($_POST['product_code']) ? $_POST['product_code'] : '';
    $product_name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $tmp_file = isset($_FILES['tmp_file']) ? $_FILES['tmp_file'] : '';

    $params = array(
        'product_name' => $product_name,
        'category' => $category,
        'descript' => $description,
        'quantity' => $quantity,
        'price' => $price,
        'file' => $tmp_file,
    );

    // - create product
    if (isset($_POST['form_saving_flg']) && $_POST['form_saving_flg'] == FORM_FLAG_SAVE) {
        $result = $productCntrl->create($params);

        if (isset($result['success'])) {
            $_SESSION['result'] = $result;
            $_SESSION['timestamp'] = time();
            $_SESSION['title'] = 'SUCCESS!';
            $_SESSION['message'] = 'Product successfully created';
            $_SESSION['message_type'] = 'success';
    
            header('Location: ../../admin/product-form.php'); 
            exit;
        }
    } 
    
    // - update product
    if (isset($_POST['form_saving_flg']) && $_POST['form_saving_flg'] == FORM_FLAG_EDIT) {
        $params['product_id'] = $product_id;
        $result = $productCntrl->update($params);

        if (isset($result['success'])) {
            $_SESSION['result'] = $result;
            $_SESSION['timestamp'] = time();
            $_SESSION['title'] = 'UPDATED!';
            $_SESSION['message'] = 'Product successfully updated';
            $_SESSION['message_type'] = 'info';
    
            header("Location: ../../admin/product-form.php?product_code=". $product_code); 
            exit;
        }
    }
    
?>