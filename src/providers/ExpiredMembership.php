<?php
    include_once '../MembershipController.php';
    $membershipCntrl = new MembershipController();

    header('Content-Type: application/json');

    $is_running_flg = isset($_POST['is_running_flg']) ? $_POST['is_running_flg'] : false;
    $current_date = date('Y-m-d');

    $checker = $membershipCntrl->expired_membership($current_date);

    if ($checker['total_count'] > 0) {
        foreach($checker['data'] as $member) {
            $request = array(
                'membership_id' => $member['id'],
                'is_expired_flg' => EXPIRED_FLAG_ON
            );
            $membershipCntrl->update_membership($request);
        }
    }

    echo json_encode($checker);
?>
