<?php
    session_start();

    include_once '../MembershipController.php';
    $membershipCntrl = new MembershipController();

    $is_update_flg = isset($_POST['is_update_flg']) ? $_POST['is_update_flg'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $days_from = isset($_POST['days_from']) ? $_POST['days_from'] : '';
    $days_to = isset($_POST['days_to']) ? $_POST['days_to'] : '';
    $time_from = isset($_POST['time_from']) ? $_POST['time_from'] : '';
    $time_to = isset($_POST['time_to']) ? $_POST['time_to'] : '';
    $days_duration = isset($_POST['days_duration']) ? $_POST['days_duration'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';

    // create
    if ($is_update_flg == 1) {
        $create_request = array(
            'plan_id' => $membershipCntrl->generate_subscription_code(),
            'title' => $title,
            'description' => $description,
            'entry_days' => $days_from .'~'. $days_to,
            'entry_time' => $time_from .'~'. $time_to,
            'days_duration' => (int)$days_duration,
            'price' => (float)$price,
            'status' => 1,
        );

        $result = $membershipCntrl->create_subscription($create_request);

        if (isset($result['success'])) {
            $_SESSION['result'] = $result;
            $_SESSION['timestamp'] = time();
            $_SESSION['title'] = 'SUCCESS!';
            $_SESSION['message'] = 'Subscription successfully created';
            $_SESSION['message_type'] = 'success';
    
            header('Location: ../../admin/subscription-form.php'); 
            exit;
        }
    }

    // update
    if ($is_update_flg == 2) {
        $plan_id = isset($_POST['plan_id']) ? $_POST['plan_id'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : '';
        $update_request = array(
            'plan_id' => $plan_id,
            'title' => $title,
            'description' => $description,
            'entry_days' => $days_from .'~'. $days_to,
            'entry_time' => $time_from .'~'. $time_to,
            'days_duration' => (int)$days_duration,
            'price' => (float)$price,
            'status' => $status,
        );
        $result = $membershipCntrl->update_subscription($update_request);

        if (isset($result['success'])) {
            $_SESSION['result'] = $result;
            $_SESSION['timestamp'] = time();
            $_SESSION['title'] = 'UPDATED!';
            $_SESSION['message'] = 'Subscription successfully updated';
            $_SESSION['message_type'] = 'info';
    
            header("Location: ../../admin/subscription-form.php?plan_id=". $plan_id); 
            exit;
        }
    }
?>
