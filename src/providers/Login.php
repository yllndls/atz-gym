<?php
     session_start();

     include_once '../UserController.php';
     $userCntrl = new UserController();

     if (isset($_POST['login'])) {
        $params = array(
            'email' => isset($_POST['email']) ? $_POST['email'] : '',
            'password' => isset($_POST['email']) ? $_POST['email'] : '',
            'type_id' => isset($_POST['type_id']) ? $_POST['type_id'] : ''
        );
        $results = $userCntrl->login($params);

        if (!!$results['success']) {
            $_SESSION['user_id'] 	 = $results['user_id'];
            $_SESSION['user_type'] = $results['user_type'];
            $_SESSION['email']   = $results['email'];
            $_SESSION['fname']   = $results['fname'];
            $_SESSION['lname']   = $results['lname'];
            $_SESSION['profile_img'] = $results['profile_img'];
            $_SESSION['is_verify_flg'] = $results['is_verify_flg'];
            $_SESSION['status'] = $results['status'];

            // - redirection
            $user_type = isset($results['user_type']) ? $results['user_type'] : '';
            switch($user_type) {
                case USER_TYPE_ADMIN:
                    header('location:../../admin/dashboard.php');
                    break;

                case USER_TYPE_MEMBER:
                    header('location:../../index.php');
                    break;
            }

        } else {
            $_SESSION['result'] = false;
            $_SESSION['timestamp'] = time();
            $_SESSION['title'] = 'INVALID ACCOUNT';
            $_SESSION['message'] = 'Invalid credential';
            $_SESSION['message_type'] = 'danger';

            $user_type = isset($_POST['type_id']) ? $_POST['type_id'] : '';
            switch($user_type) {
                case USER_TYPE_ADMIN:
                    header('location:../../admin/dashboard.php');
                    break;

                case USER_TYPE_MEMBER:
                    header('location:../../login.php');
                    break;
            }
        }
     }
?>