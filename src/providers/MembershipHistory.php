<?php
    include_once '../MembershipController.php';
    $membershipCntrl = new MembershipController();

    header('Content-Type: application/json');

    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
    $details = $membershipCntrl->membership_history($user_id);

    echo json_encode($details);
?>
