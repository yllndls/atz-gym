<?php
    include_once '../UserController.php';
    $userCntrl = new UserController();

    header('Content-Type: application/json');

    $type_id = isset($_POST['type_id']) ? $_POST['type_id'] : null;
    $fname = isset($_POST['fname']) ? $_POST['fname'] : null;
    $lname = isset($_POST['lname']) ? $_POST['lname'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : null;

    // - validate password
    if ($password == $confirm_password) {
        $response = array(
            'type_id' => $type_id,
            'fname' => $fname,
            'lname' => $lname,
            'email' => $email,
            'password' =>  password_hash($password, PASSWORD_DEFAULT)
        );

        $email_validate = $userCntrl->userValidation($response);
        if ($email_validate['count'] == 0) {
            $result = $userCntrl->create($response);
            $result['message'] = 'Hello ' . $email . ', Welcome to ATZ Fitness Gym!';
        } else {
            $result = array(
                'success' => false,
                'message' => 'Email '.  $email . ' is already existing'
            );
        }
        
    } else {
        $result = array(
            'success' => false,
            'message' => 'Password is not match'
        );
    }

    echo json_encode($result);
?>