<?php
    session_start();

    include_once '../UserController.php';
    $userCntrl = new UserController();

	if(session_destroy()) {
        // - update user status
        $update_params = array(
            'user_id' => $_SESSION['user_id'],
            'is_online_flg' => OFFLINE_FLAG,
            'last_active' => true
        );
        $update_status = $userCntrl->update($update_params);

        // - redirection
        $user_type = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : '';
        switch($user_type) {
            case USER_TYPE_ADMIN:
                $_SESSION = array();
                header('location:../../admin/index.php');
                break;

            case USER_TYPE_MEMBER:
                header('location:../../index.php');
                break;
        }
	}
?>