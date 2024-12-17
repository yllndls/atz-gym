<?php
    session_start();

    include_once '../UserController.php';
    include_once '../TmpFileController.php';
    $userCntrl = new UserController();
    $uploadCntrl = new TmpFileController();

    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
    $fname = isset($_POST['fname']) ? $_POST['fname'] : null;
    $lname = isset($_POST['lname']) ? $_POST['lname'] : null;
    $gender = isset($_POST['gender']) ? $_POST['gender'] : null;
    $bday = isset($_POST['bday']) ? $_POST['bday'] : null;
    $contact = isset($_POST['contact']) ? $_POST['contact'] : null;
    $address = isset($_POST['address']) ? $_POST['address'] : null;

    $response = array(
        'user_id' => $user_id,
        'fname' => $fname,
        'lname' => $lname,
        'gender' => $gender,
        'bday' => $bday,
        'contact' => $contact,
        'address' => $address,
        'is_verify_flg' => PROFILE_VERIFY,
    );

    if (isset($_FILES['tmp_file'])) {
        $datas = array(
            'file' => $_FILES['tmp_file'],
            'resources_id' => $user_id,
            'resources' => TMP_UPLOAD_PROFILE
        );

        if (isset($_POST['is_profile_flg']) && $_POST['is_profile_flg'] == 1) {
            $datas['is_update_flg'] = true;
        }

        $updaloaded = $uploadCntrl->tmp_file($datas);
        if (!!$updaloaded['success']) {
            $response['is_profile_flg'] = PROFILE_VERIFY;
            $_SESSION['profile_img'] = $updaloaded['filename'];
        }
    }

    $result = $userCntrl->update($response);

    if (!!$result['success']) {
        // - reset details in session
        $_SESSION['fname'] = $fname;
        $_SESSION['lname'] = $lname;

        // - results
        $_SESSION['result'] = $result;
        $_SESSION['timestamp'] = time();
        $_SESSION['title'] = 'UPDATED!';
        $_SESSION['message'] = 'Your details was successfully updated';
        $_SESSION['message_type'] = 'info';
    } else {
        $_SESSION['result'] = $result;
        $_SESSION['timestamp'] = time();
        $_SESSION['title'] = 'INVALID!';
        $_SESSION['message'] = 'You have problem w/ your information';
        $_SESSION['message_type'] = 'danger';
    }

    header('location:../../settings.php');
?>